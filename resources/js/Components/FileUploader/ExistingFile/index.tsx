import MuxPlayer from "@mux/mux-player-react";
import {Cross} from "@/Components/Icons/Cross";
import {BaseFile } from "@/Components/FileUploader";
import {useCdnLink} from "@/Hooks/useCdnLink";
import {LoadingFile} from "@/Components/FileUploader/ExistingFile/LoadingFile";

type Props = {
    file: BaseFile;
    onDelete: (file: BaseFile) => void
}

export function ExistingFile({ file, onDelete }: Props) {

    const cdnLink = useCdnLink();


    return (
        <div className={"relative aspect-square"}>

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
                <div onClick={() => {onDelete(file) }} className={'absolute cursor-pointer top-0 right-0 p-1 z-10 text-teal bg-teal-100 bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                    <Cross className={"h-4 w-4"} />
                </div>
            }
        </div>
    );
}
