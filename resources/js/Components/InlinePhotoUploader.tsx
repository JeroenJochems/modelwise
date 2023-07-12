import {FormEvent} from "react";
import Vapor from "laravel-vapor";
import {ReactSortable} from "react-sortablejs";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Portfolio";

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
    onDeletePhoto: (id: string|number) => void
    onUpdateSorting: (photos: Photo[]) => void
    slots?: number
    cols?: number
}

export function InlinePhotoUploader({ photos, onAddPhoto, onDeletePhoto, onUpdateSorting, slots=6, cols=6}: Props) {

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        Array.from(e.target.files).map((file, i) => {
            Vapor.store(file)
                .then(response => {
                    onAddPhoto(response.uuid, response.key, URL.createObjectURL(file));
                });
        });
    }

    function handleDelete(photo: Photo) {
        onDeletePhoto(photo.id);
    }

    return (
        <div>
            <ReactSortable tag={"div"} list={photos} setList={onUpdateSorting} className={`grid grid-cols-${cols} gap-2`}>
                { photos.filter(photo => !photo.deleted).map((photo: Photo) =>
                    <div key={photo.id}
                         className={'cursor-pointer w-full h-full aspect-[1/1] border rounded-md overflow-hidden relative'}>
                        <div onClick={() => {
                            handleDelete(photo)
                        }}
                             className={'absolute top-0 right-0 p-1 bg-white bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>
                            x
                        </div>
                        <img src={photo.path} key={photo.id}
                             className={"rounded-sm aspect-square w-full h-full aspect-[1/1] overflow-hidden"}/>
                    </div>
                )}

                { [...Array(Math.max(0, slots - photos.filter(photo => !photo.deleted).length))].map((item, i) => (
                    <label key={i} htmlFor="photo"
                           className={"flex text-gray-500 text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-400 rounded-sm"}>
                        +
                    </label>
                ))}
            </ReactSortable>


            <input type="file" id="photo" className={"hidden"}
                       name="photo"
                       multiple={true}
                       onChange={handleChange}/>
        </div>
    )
}
