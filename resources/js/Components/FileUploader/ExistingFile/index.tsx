import MuxPlayer from "@mux/mux-player-react";
import {Cross} from "@/Components/Icons/Cross";
import {BaseFile } from "@/Components/FileUploader";
import {useCdnLink} from "@/Hooks/useCdnLink";
import {LoadingFile} from "@/Components/FileUploader/ExistingFile/LoadingFile";
import clsx from "clsx";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";

type Props = {
    file: BaseFile;
    onDelete: (file: BaseFile) => void
    className?: string
}

export function ExistingFile({ file, onDelete, className=''}: Props) {
    const cdnLink = useCdnLink();

    const {
        attributes,
        listeners,
        setNodeRef,
        transform,
        transition,
        isDragging
    } = useSortable({ id: file.id?.toString() });

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        zIndex: isDragging ? 1000 : 1,
    };

    return (
        <div
            className={clsx(
                className,
                `relative aspect-square`,
                isDragging && 'opacity-75'
            )}
            ref={setNodeRef}
            style={style}
            {...attributes}
        >
            { file.mime.includes("video") && (
                <>
                 { file.muxStatus === 'processing' || (file.muxUploadId && !file.muxId)
                     ? <div className={"flex flex-col gap-2 items-center justify-center rounded-lg w-full h-full bg-teal-100 text-teal text-xs text-center p-2"}>
                         <svg className="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                             <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                             <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                         </svg>
                         <span>Processing...</span>
                     </div>
                     : file.muxStatus === 'errored'
                     ? <div className={"flex items-center justify-center rounded-lg w-full h-full bg-red-100 text-red-700 text-xs text-center p-2"}>
                         { file.muxError || 'Upload failed' }
                     </div>
                     : !!file.isNew && !file.muxUploadId
                     ? <video controls preload="metadata" className={"object-cover rounded-lg w-full h-full bg-black"}><source src={cdnLink(file.path)} /></video>
                     : <MuxPlayer playbackId={file.muxId} className={"object-cover rounded-lg w-full h-full"} />
                 }
                 </>
            )}

            { file.mime.includes("image") && (
                <LoadingFile className={"object-cover rounded-lg w-full h-full"} src={cdnLink(file.path, "face_square") } />
            )}

            <button
                type="button"
                onClick={() => onDelete(file)}
                aria-label="Remove"
                className={'absolute cursor-pointer top-0 right-0 p-1 z-20 text-teal bg-teal-100 bg-opacity-50 hover:bg-opacity-100 transition duration-200'}
            >
                <Cross className={"h-4 w-4"} />
            </button>
            <div
                {...listeners}
                aria-label="Drag to reorder"
                className={'absolute cursor-grab active:cursor-grabbing top-0 left-0 p-1 z-10 text-teal bg-teal-100 bg-opacity-50 hover:bg-opacity-100 transition duration-200 select-none'}
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" className="h-4 w-4">
                    <circle cx="5" cy="4" r="1.2" /><circle cx="5" cy="8" r="1.2" /><circle cx="5" cy="12" r="1.2" />
                    <circle cx="11" cy="4" r="1.2" /><circle cx="11" cy="8" r="1.2" /><circle cx="11" cy="12" r="1.2" />
                </svg>
            </div>
        </div>
    );
}
