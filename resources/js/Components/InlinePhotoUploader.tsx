import {FormEvent, useEffect, useRef, useState} from "react";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import {Link, usePage} from "@inertiajs/react";
import {PageProps} from "@/types";
import ModelPhotoData = Domain.Models.Data.ModelPhotoData;
import PrimaryButton from "@/Components/PrimaryButton";
import SmallButton from "@/Components/SmallButton";
import InputGroupText from "@/Components/Forms/InputGroupText";

export type Photo = {
    id: string
    path: string
    tmpFile?: string
    folder?: string
    deleted?: boolean
    filtered?: boolean
}

type Props = {
    photos: Array<Photo>
    onUpdate: (photos: Photo[]) => void
    onAdd: (photo: Photo) => void
    onToggleUploading?: (state: boolean) => void
    slots?: number
    cols?: number
}

type UploadProgress = {
    id: string
    progress: number
}

type ResponseType = {
    uuid: string
    key: string
}

export function InlinePhotoUploader({photos, onAdd, onUpdate, onToggleUploading, slots = 6, cols = 6}: Props) {

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
                signedStorageUrl: '/photos/signed-url',
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

    function handleDelete({ id }: Photo) {
        onUpdate(photos.map((photo) => {
            if (photo.id === id) {
                photo.deleted = true;
            }
            return photo;
        }));
    }


    return (
        <div>
            <ReactSortable tag={"div"} list={photos} setList={onUpdate} className={`grid grid-cols-${cols} gap-2`}>
                {photos.filter(photo => !photo.deleted).map((photo: Photo) =>
                    <div key={photo.id} className={'cursor-pointer w-full h-full aspect-[1/1] border rounded-md overflow-hidden relative'}>
                        <div onClick={() => {handleDelete(photo) }} className={'absolute top-0 right-0 p-1 bg-white bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                            x
                        </div>
                        <img src={photo.path} key={photo.id} className={"rounded-sm aspect-square object-cover w-full h-full aspect-[1/1] overflow-hidden"} />
                    </div>
                )}

                {[...Array(Math.max(0, slots - photos.filter(photo => !photo.deleted).length))].map((item, i) => (
                    <label key={i} onClick={() => !!ref.current && ref.current.click() } className={"flex text-gray-500 text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-400 rounded-sm"}>
                        +
                    </label>
                ))}
            </ReactSortable>

            { photos.length >= slots && (
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
        </div>
    )
}
