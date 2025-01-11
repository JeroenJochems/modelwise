import {useEffect, useId, useRef, useState} from "react";
import axios from "axios";
import {ProgressBar} from "@/Components/FileUploader/ProgressBar";
import {useCdnLink} from "@/Hooks/useCdnLink";
import {v4 as uuidv4} from "uuid";
import {ExistingFile} from "@/Components/FileUploader/ExistingFile";
import clsx from "clsx";
import {useBreakpoint} from "@/Hooks/useBreakpoint";

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

export type BaseFile = {
    id: number|string
    path: string
    mime: string
    muxId?: string
    isNew?: boolean
    deleted?: boolean
}

type ResponseType = {
    uuid: string
    url: string
    key: string
    headers: {
        [key: string]: string
    }
}

interface FileData {
    id: string;
    file: File;
    size: number;
    uploadedSize: number;
    success?: boolean;
    abortController: AbortController
}


export function FileUploader2({ name, files, error, max = 99, slots = 6, cols = 6, colsOnMobile = 4, accept, onAdd, onUpdate, onToggleUploading, opaqueAfter=undefined }: Props) {

    const id = useId();
    const cdnLink = useCdnLink();
    const [progress, setProgress] = useState<number|undefined>()
    const [uploadingFiles, setUploadingFiles] = useState<FileData[]>([]);
    const ref = useRef<HTMLInputElement>(null);
    const longPressTimeoutRef = useRef<NodeJS.Timeout | null>(null);
    const [isDraggingEnabled, setIsDraggingEnabled] = useState(false);
    const { isMd } = useBreakpoint('md');


    if (accept==="image/*") {
        accept = "image/avif,image/gif,image/heif,image/heic,image/jpeg,image/png,image/webp"
    }

    const handleFileSelect = () => {

        if (!ref.current?.files) return;

        const newFiles = Array.from(ref.current.files).map((file) => ({
            file,
            id: `${file.name}-${file.size}-${Date.now()}`,
            abortController: new AbortController(),
            size: file.size,
            uploadedSize: 0,
        }));

        newFiles.forEach(file => uploadFile(file));

        setUploadingFiles((prev) => [...prev, ...newFiles]);
    };

    useEffect(() => {
        console.log(uploadingFiles);
    }, [uploadingFiles]);

    function endedUpload(id: string, success: boolean = true) {

        setUploadingFiles(prev => prev.map((f) => {
            if (f.id === id) {
                return {
                    ...f,
                    success: success
                }
            }
            return f;
        }));
    }

    function deleteUploadingFile(id: string) {
        const file = uploadingFiles.find(f => f.id == id);
        if(!file) return;

        file.abortController.abort();

        setUploadingFiles(prev => prev.filter(f => f.id !== id));
    }

    const handleLongPress = () => {

        longPressTimeoutRef.current = setTimeout(() => {
            setIsDraggingEnabled(true);
        }, 500);
    };

    // Cancel long press if the user releases early
    const cancelLongPress = () => {
        if (longPressTimeoutRef.current) {
            clearTimeout(longPressTimeoutRef.current);
            longPressTimeoutRef.current = null;
        }
    };

    useEffect(() => {
        console.log(uploadingFiles);
    }, [uploadingFiles]);

    useEffect(() => {

        if (!uploadingFiles) setProgress(undefined);

        let totalSize = 0;
        let totalUploadedSize = 0;

        uploadingFiles
            .forEach(file => {
                totalSize += file.size;
                totalUploadedSize += file.uploadedSize;
            });


        setProgress(totalUploadedSize / totalSize);
    }, [uploadingFiles]);

    function updateUploadedFile(file: FileData, properties: Partial<FileData>) {
        setUploadingFiles(prev =>
            prev.map(f =>
                f.id === file.id
                    ? {...f, ...properties}
                    : f
            )
        );
    }



    const uploadFile = async (fileData: FileData) => {

        const response: { data: ResponseType } = await axios.post('/signed-url');

        let headers = response.data.headers;

        if ('Host' in headers) {
            delete headers.Host;
        }

        try {
            const uploadResponse: ResponseType = await axios.put(response.data.url, fileData.file, {
                signal: fileData.abortController.signal,
                headers,
                onUploadProgress: (progressEvent) => {
                    updateUploadedFile(fileData, { uploadedSize: progressEvent.loaded})
                }
            });

            updateUploadedFile(fileData, { success: true });
            onAdd({
                id: uuidv4(),
                path: response.data.key,
                isNew: true,
                mime: fileData.file.type,
                deleted: false,
            });

        } catch (error) {
            updateUploadedFile(fileData, { success: false })
        }
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

    function filterDeleted(file: BaseFile) {
        return !file.deleted;
    }

    let emptySlots = slots - files.filter(filterDeleted).length;
    if (emptySlots<=0) emptySlots = cols;

    return <>
        <div className={`relative grid mb-4 gap-2 grid-cols-${colsOnMobile} sm:grid-cols-${cols}`}>

            { files.filter(filterDeleted).map((file, index) => (
                <div
                    onTouchStart={handleLongPress}
                    onTouchEnd={cancelLongPress}
                    onMouseDown={handleLongPress}
                    onMouseUp={cancelLongPress}>
                    <ExistingFile
                        className={clsx((opaqueAfter!==undefined && index>=opaqueAfter) ? 'opacity-25' : '', isDraggingEnabled && 'animate-spin' )}
                        key={file.id ?? file.path}
                        onDelete={handleDelete}
                        file={file}/>
                </div>
            ))}

            { emptySlots > 0 && Array(emptySlots).fill('').map((x, i) => (
                <label key={i} htmlFor={id}
                       className={"static flex rounded text-teal text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-teal-100 border border-gray-400"}>
                    +
                </label>)
            )}

        </div>

        {isDraggingEnabled &&
            <div onClick={() => setIsDraggingEnabled(false)} className={"my-2 text-center"}>done</div>}

        {!!progress && <ProgressBar progress={progress}/>}

        <input name={name} ref={ref} type="file" id={id} accept={accept} multiple onChange={handleFileSelect}/>
    </>
}
