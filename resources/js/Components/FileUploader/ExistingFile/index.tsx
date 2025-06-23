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
                 { !!file.isNew
                     ? <video controls className={"object-cover rounded-lg w-full h-full"}><source src={cdnLink(file.path)} /></video>
                     : <MuxPlayer playbackId={file.muxId} className={"object-cover rounded-lg w-full h-full"} />
                 }
                 </>
            )}

            { file.mime.includes("image") && (
                <LoadingFile className={"object-cover rounded-lg w-full h-full"} src={cdnLink(file.path, "face_square") } />
            )}

            {
                <>
                    <div onClick={() => {onDelete(file) }} className={'absolute cursor-pointer top-0 right-0 p-1 z-999 text-teal bg-teal-100 bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                        <Cross className={"h-4 w-4"} />
                    </div>
                    <div {...listeners} className={'absolute cursor-pointer left-0 top-0 bottom-0 right-4'} />

                </>
            }
        </div>
    );
}
