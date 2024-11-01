import {FormEvent, useEffect, useId, useState} from "react";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import {useUploadProgress} from "@/Hooks/useUploadProgress";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {v4 as uuidv4} from 'uuid';
import {ProgressBar} from "@/Components/FileUploader/ProgressBar";
import {ExistingFile} from "@/Components/FileUploader/ExistingFile";
import InputError from "@/Components/InputError";

export type BaseFile = {
    muxId?: string
    id: number|string
    mime: string
    path: string
    tmpLocalFile?: File
    isNew?: boolean
    deleted?: boolean
}

type ResponseType = {
    uuid: string
    key: string
}

type Props = {
    name?: string
    files: BaseFile[]
    cols?: number
    max?: number
    error?: string
    slots?: number
    colsOnMobile?: number
    onAdd: (file: BaseFile) => void
    accept?: string
    onUpdate: (videos: BaseFile[]) => void
    onToggleUploading?: (state: boolean) => void
    opaqueAfter?: number
}

export function FileUploader({ name, files, error, max = 99, slots = 6, cols = 6, colsOnMobile = 2, accept, onAdd, onUpdate, onToggleUploading, opaqueAfter=undefined }: Props) {

    const id = useId();
    const {totalProgressRatio, addFileToProgress, updateProgress} = useUploadProgress();

    const [selectedFiles, setSelectedFiles] = useState<File[]>([]);

    if (accept==="image/*") {
        accept = "image/avif,image/gif,image/heif,image/heic,image/jpeg,image/png,image/webp"
    }

    useEffect(() => {
        onToggleUploading && selectedFiles.length>0 && totalProgressRatio % 1 === 0 && onToggleUploading(totalProgressRatio === 0);
    }, [totalProgressRatio]);

    const notDeletedFiles = files.filter((file) => {
        if (file.deleted === undefined) return true;
        return !file.deleted;
    });

    const newFiles = files.filter((file) => {
        return file.isNew;
    });

    const emptySlots = slots - notDeletedFiles.length > 0
        ? Array(slots - notDeletedFiles.length).fill('')
        : [];


    return (
        <>
            <ReactSortable tag={"div"} list={files} setList={onUpdate} className={`grid mb-4 gap-2 grid-cols-${colsOnMobile} sm:grid-cols-${cols}`}>
                {notDeletedFiles.map((file, index) => {
                    return <ExistingFile className={(opaqueAfter!==undefined && index>=opaqueAfter) ? 'opacity-25' : ''} key={file.id ?? file.path} onDelete={handleDelete} file={file}/>
                })}
            </ReactSortable>

            { notDeletedFiles.length==0 && (
                <div className={`grid gap-2 grid-cols-${colsOnMobile} sm:grid-cols-${cols}`}>
                    {emptySlots.map((slot, i) => (
                        <label key={i} htmlFor={id} className={"static flex rounded text-teal text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-teal-100 border border-gray-400"}>
                            +
                        </label>)
                    )}
                </div>
            )}


            { max>1 && notDeletedFiles.length > 0 && (
                <div className={"text-center mb-2"}>
                    <label htmlFor={id} className={"text-gray-800 rounded p-2 border border-gray-600 items-center text-center cursor-pointer "}>
                        + add { accept?.includes('video') ? 'videos' : 'photos' }
                    </label>
                </div>
            )}

            { totalProgressRatio > 0 && totalProgressRatio < 1 && (
                <ProgressBar progress={totalProgressRatio} />
            )}

            { !!error && <InputError message={error} /> }

            <input name={name} type="file" id={id} accept={accept} multiple className={"hidden"} onChange={handleChange}/>
        </>
    );

    async function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files === null || !e.target.files[0]) return;

        // load a maximum # files to prevent timeout
        const files = Array.from(e.target.files).slice(0,25);

        setSelectedFiles(files);

        files.map(async (file) => {

            addFileToProgress(file.name);

            Vapor
                .store(file, {
                    // @ts-ignore
                    signedStorageUrl: '/signed-url',
                    progress: progress => updateProgress(file.name, progress)
                })
                .then(function (response: ResponseType) {

                    setSelectedFiles(s => [...s].filter(f => f.name !== file.name));

                    onAdd({
                        id: uuidv4(),
                        path: response.key,
                        isNew: true,
                        mime: file.type,
                        deleted: false,
                    });

                });
        });
    }

    function handleDelete({ id }: BaseFile) {

        if (!onUpdate) return;

        onUpdate(files.map((file) => {
            if (file.id === id) {
                file.deleted = true;
            }
            return file;
        }));
    }


}
