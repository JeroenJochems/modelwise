import {FormEvent, useEffect, useRef, useState} from "react";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import { usePage} from "@inertiajs/react";
import {PageProps} from "@/types";
import SmallButton from "@/Components/SmallButton";
import InputError from "@/Components/InputError";
import {Cross} from "@/Components/Icons/Cross";

export type Video = {
    id: string
    path: string
    tmpFile?: string
    folder?: string
    deleted?: boolean
    filtered?: boolean
}

type Props = {
    photos: Array<Video>
    onUpdate?: (photos: Video[]) => void
    onAdd: (media: Video) => void
    onToggleUploading?: (state: boolean) => void
    slots?: number
    cols?: number
    max?: number
    colsOnMobile?: number
    error?: string
}

type UploadProgress = {
    id: string
    progress: number
}

type ResponseType = {
    uuid: string
    key: string
}

export function InlinVideoUploader({videos, onAdd, error, onUpdate, onToggleUploading, colsOnMobile=3, slots = 6, max=99, cols = 6}: Props) {

    const ref = useRef<HTMLInputElement | null>(null)
    const [uploadProgress, setUploadProgress] = useState<UploadProgress[]>([]);
    const {cdn_url} = usePage<PageProps>().props;

    const progress = uploadProgress.length ? Math.round((uploadProgress.reduce(function (sum, item) {
        return sum + item.progress;
    }, 0) / uploadProgress.length) * 100) : null;

    useEffect(() => {
        if (progress===0) {
            onToggleUploading ? onToggleUploading(true) : null;
        } else {
            onToggleUploading ? onToggleUploading(false) : null;
        }

    }, [progress]);

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files === null) return;

        Array.from(e.target.files).map((file, i) => {


            setUploadProgress((progres) => {
                const oldProgress = [...progres];
                oldProgress.push({id: file.name, progress: 0});
                return oldProgress;
            });

            Vapor.store(file, {
                // @ts-ignore
                signedStorageUrl: '/signed-url',
                progress: progress => {
                    setUploadProgress((progres) => {
                        return progres.map((item) => {
                            if (item.id === file.name) {
                                item.progress = progress;
                            }
                            return item;
                        });
                    });

                }
            })
                .then((response: ResponseType) => {

                    onAdd({
                        id: response.uuid,
                        tmpFile: response.key,
                        path: `${cdn_url}/${response.key}?w=600&h=600&fm=auto&fit=crop&crop=faces`
                    });
                });
        });
    }

    function handleDelete({ id }: Video) {
        if (!onUpdate) return;

        onUpdate(photos.map((photo) => {
            if (photo.id === id) {
                photo.deleted = true;
            }
            return photo;
        }));
    }


    return (
        <div>
            <ReactSortable tag={"div"} list={photos} setList={onUpdate} className={`grid grid-cols-${colsOnMobile} sm:grid-cols-${cols} gap-2`}>

                {photos.filter(photo => !photo.deleted).map((photo: Video) =>
                    <div key={photo.id} className={'cursor-pointer w-full h-full aspect-[1/1] border rounded overflow-hidden relative'}>
                        <div onClick={() => {handleDelete(photo) }} className={'absolute top-0 right-0 p-1 text-teal bg-teal-100 bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                            <Cross className={"h-4 w-4"} />
                        </div>
                        <img src={photo.path} key={photo.id} className={"rounded-sm aspect-square object-cover w-full h-full aspect-[1/1] overflow-hidden"} />
                    </div>
                )}

                {[...Array(Math.max(0, slots - photos.filter(photo => !photo.deleted).length))].map((item, i) => (
                    <label key={i} onClick={() => !!ref.current && ref.current.click() } className={"flex rounded text-teal text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-teal-100 border border-gray-400"}>
                        +
                    </label>
                ))}
            </ReactSortable>

            { max>1 && photos.length >= slots && (
                <div className={"flex items-center mt-4"}>
                    <SmallButton onClick={() => !!ref.current && ref.current.click()} className={"mx-auto"}>+ Add more photos</SmallButton>
                </div>
            )}

            <div className={"h-2 mt-2 w-full h-2"}>
                { !!progress && progress < 100 && (
                    <div className="w-full bg-gray-100 h-2 rounded-full">
                        <div style={{ width: progress + '%'}}  className="bg-green h-2 rounded-full"></div>
                    </div>
                )}
            </div>

            <input type="file" ref={ref} className={"hidden"} name="photo" multiple={true} onChange={handleChange}/>

            { !!error && (
                <InputError message={error} />
            )}
        </div>
    )
}