import {FormEvent, useEffect, useId, useRef, useState} from "react";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import {useUploadProgress} from "@/Hooks/useUploadProgress";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {v4 as uuidv4} from 'uuid';
import {ProgressBar} from "@/Components/FileUploader/ProgressBar";
import {ExistingFile} from "@/Components/FileUploader/ExistingFile";
import SmallButton from "@/Components/SmallButton";
import InputError from "@/Components/InputError";
import Resizer from "react-image-file-resizer";


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

    const id = useId();
    const {totalProgressRatio, addFileToProgress, updateProgress} = useUploadProgress();

    const [selectedFiles, setSelectedFiles] = useState<File[]>([]);

    useEffect(() => {
        onToggleUploading && selectedFiles.length>0 && totalProgressRatio % 1 === 0 && onToggleUploading(totalProgressRatio === 0);
    }, [totalProgressRatio]);

    const notDeletedFiles = files.filter((file) => {

        if (file.deleted === undefined) return true;

        return !file.deleted;
    });

    const emptySlots = slots - notDeletedFiles.length > 0
        ? Array(slots - notDeletedFiles.length).fill('')
        : [];


    return (
        <>
            <ReactSortable tag={"div"} list={files} setList={onUpdate} className={`grid gap-2 grid-cols-${colsOnMobile} sm:grid-cols-${cols}`}>
                {notDeletedFiles.map(file => <ExistingFile key={file.id ?? file.path} onDelete={handleDelete} file={file}/>)}
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
                <label htmlFor={id} className={"border border-gray-300 rounded-md p-2 mt-2 items-center inline-flex cursor-pointer "}>
                    + Add more photos
                </label>
            )}

            <ProgressBar progress={totalProgressRatio} />

            <InputError message={error} />

            <input type="file" id={id} accept={accept} multiple className={"hidden"} onChange={handleChange}/>
        </>
    );

    function resizeFile(file: File): Promise<string> {

        return new Promise((resolve) => {
            Resizer.imageFileResizer(
                file,
                2000,
                2000,
                "JPEG",
                100,
                0,
                (uri) => {
                    /** @ts-ignore */
                    resolve(uri);
                },
                "base64"
            );
        });
    }

    async function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files === null || !e.target.files[0]) return;

        setSelectedFiles(Array.from(e.target.files));

        Array.from(e.target.files).map(async (file, i) => {

            if (file.size > 10000000) {
                const image = await resizeFile(file);
                file = blobToFile(base64ToBlob(image), file.name);
            }

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

    function base64ToBlob(base64Data: string) {
        const parts = base64Data.split(';base64,');
        const imageType = parts[0].split(':')[1];
        const base64 = parts[1];
        const byteCharacters = atob(base64);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);

        return new Blob([byteArray], { type: imageType });
    }

    function blobToFile(blob: Blob, fileName: string) {
        return new File([blob], fileName, { type: blob.type });
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
