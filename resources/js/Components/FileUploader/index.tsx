import {FormEvent, useEffect, useRef, useState} from "react";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import {useUploadProgress} from "@/Hooks/useUploadProgress";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {v4 as uuidv4} from 'uuid';
import {ProgressBar} from "@/Components/FileUploader/ProgressBar";
import {ExistingFile} from "@/Components/FileUploader/ExistingFile";
import SmallButton from "@/Components/SmallButton";
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
}

export function FileUploader({ files, error, max = 99, slots = 6, cols = 6, colsOnMobile = 3, accept, onAdd, onUpdate, onToggleUploading }: Props) {

    const {totalProgressRatio, addFileToProgress, updateProgress} = useUploadProgress();
    const ref = useRef<HTMLInputElement | null>(null)

    const [selectedFiles, setSelectedFiles] = useState<File[]>([]);

    useEffect(() => {
        onToggleUploading && selectedFiles.length>0 && totalProgressRatio % 1 === 0 && onToggleUploading(totalProgressRatio === 0);
    }, [totalProgressRatio]);

    const notDeletedFiles = files.filter(file => !file.deleted);
    const emptySlots = slots - notDeletedFiles.length > 0
        ? Array(slots - notDeletedFiles.length).fill('')
        : [];

    return (
        <>
            <ReactSortable tag={"div"} list={files} setList={onUpdate} className={`grid grid-cols-${colsOnMobile} sm:grid-cols-${cols} gap-2`}>
                {notDeletedFiles.map(file => <ExistingFile key={file.id ?? file.path} onDelete={handleDelete} file={file}/>)}
                {emptySlots.map((slot, i) => (
                    <div key={i}
                         onClick={() => !!ref.current && ref.current.click()}
                         className={"flex rounded text-teal text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-teal-100 border border-gray-400"}>
                        +
                    </div>)
                )}
            </ReactSortable>

            { max>1 && notDeletedFiles.length >= slots && (
                <div className={"flex items-center"}>
                    <SmallButton onClick={() => !!ref.current && ref.current.click()} className={"mx-auto"}>+ Add more photos</SmallButton>
                </div>
            )}

            <ProgressBar progress={totalProgressRatio} />

            <InputError message={error} />

            <input type="file" accept={accept} ref={ref} multiple className={"hidden"} onChange={handleChange}/>
        </>
    );


    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files === null || !e.target.files[0]) return;

        setSelectedFiles(Array.from(e.target.files));

        Array.from(e.target.files).map((file, i) => {

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
