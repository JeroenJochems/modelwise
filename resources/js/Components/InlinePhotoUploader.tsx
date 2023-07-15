import {FormEvent, useEffect, useState} from "react";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";
import {usePage} from "@inertiajs/react";
import {PageProps} from "@/types";

export type ExistingPhoto = {
    id: number
    path: string
    deleted?: boolean
    filtered?: boolean
}

export type NewPhoto = {
    id: string
    path: string
    tmpFile: string
    deleted?: boolean
    filtered?: boolean
}

export type Photo = ExistingPhoto | NewPhoto;


type Props = {
    photos: Photo[]
    onAddPhoto: (id: string, tmpFile: string, url: string) => void
    onStart?: () => void
    onFinished?: () => void
    onDeletePhoto: (id: string | number) => void
    onUpdateSorting: (photos: Photo[]) => void
    slots?: number
    cols?: number
}

type UploadProgress = {
    id: string
    progress: number
}

export function InlinePhotoUploader({photos, onAddPhoto, onDeletePhoto, onStart, onFinished, onUpdateSorting, slots = 6, cols = 6}: Props) {

    const [uploadProgress, setUploadProgress] = useState<UploadProgress[]>([]);
    const {cdn_url} = usePage<PageProps>().props;

    const progress = uploadProgress.length ? Math.round((uploadProgress.reduce(function (sum, item) {
        return sum + item.progress;
    }, 0) / uploadProgress.length) * 100) : null;

    useEffect(() => {
        if (progress===0) {
            onStart ? onStart() : null;
        }
        if (progress===100) {
            onFinished ? onFinished() : null;
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
                .then(response => {
                    onAddPhoto(response.uuid, response.key, `${cdn_url}/${response.key}?w=600&h=600&fm=auto&fit=crop&crop=faces`);
                });
        });
    }


    function handleDelete(photo: Photo) {
        onDeletePhoto(photo.id);
    }


    return (
        <div>
            <ReactSortable tag={"div"} list={photos} setList={onUpdateSorting}
                           className={`grid grid-cols-${cols} gap-2`}>
                {photos.filter(photo => !photo.deleted).map((photo: Photo) =>
                    <div key={photo.id}
                         className={'cursor-pointer w-full h-full aspect-[1/1] border rounded-md overflow-hidden relative'}>
                        <div onClick={() => {
                            handleDelete(photo)
                        }}
                             className={'absolute top-0 right-0 p-1 bg-white bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                            x
                        </div>
                        <img src={photo.path} key={photo.id}
                             className={"rounded-sm aspect-square object-cover w-full h-full aspect-[1/1] overflow-hidden"}/>
                    </div>
                )}

                {[...Array(Math.max(0, slots - photos.filter(photo => !photo.deleted).length))].map((item, i) => (
                    <label key={i} htmlFor="photo"
                           className={"flex text-gray-500 text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-400 rounded-sm"}>
                        +
                    </label>
                ))}
            </ReactSortable>

            <div className={"h-2 mt-2"}>
                { progress && progress < 100 ? (
                    <div className="w-full bg-gray-100 h-2 rounded-full">
                        <div style={{ width: progress + '%'}}  className="bg-green h-2 rounded-full"></div>
                    </div>
                    ) : (
                    <div className={"w-full h-2"}></div>
                ) }
            </div>

            <input type="file" id="photo" className={"hidden"}
                   name="photo"
                   multiple={true}
                   onChange={handleChange}/>

        </div>
    )
}
