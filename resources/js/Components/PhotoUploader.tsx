import {FormEvent, useState} from "react";
import {router} from "@inertiajs/react";
import Vapor from "laravel-vapor";
import {FileEventTarget} from "@/Pages/Model/Onboarding/Photos";
import {ReactSortable} from "react-sortablejs";

type Photo = {
    id: string | number
    chosen?: boolean;
    path?: string
    filtered?: boolean;
    deleteRoute?: string,
}

type Props = {
    folder: string,
    photos: Photo[]
    slots?: number
}

export function PhotoUploader({folder, photos, slots=6}: Props) {

    [...Array(slots - photos.length)].map((item, i) => {
        photos.push({id: -1 * i+1, filtered: true});
    })

    const currentSorting = photos
        .filter((item, i) => !item.filtered)
        .map((item, i) => item.id)
        .join(",")

    const [sorting, setSorting] = useState(currentSorting);


    const [state, setState] = useState(photos);

    const newSorting = state
        .filter((item, i) => !item.filtered)
        .map((item, i) => item.id)
        .join(",");

    if (newSorting != sorting) {
        setSorting(newSorting);
        router.post(route('model.photos.sort'), { sorting: newSorting }, { preserveState: true });
    }

    function handleDelete(route: string) {
        router.delete(route, { preserveState: false })
    }

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        Array.from(e.target.files).map((file, i) => {
            Vapor.store(file)
                .then(response => {
                    router.post(route('model.photos.store'), { folder, path:  response.key }, { preserveState: false })
                })
        });

    }


    return (
        <form>
            <ReactSortable list={state} setList={setState} className={"grid grid-cols-3 gap-4"}>
                { state.map((item, i) => {

                    if (!item.filtered) {
                        return (
                            <div key={item.id}
                                 className={'w-full h-full aspect-[1/1] border rounded-md overflow-hidden relative'}>
                                <a onClick={(e) => {
                                    e.preventDefault();
                                    handleDelete(item.deleteRoute || '')
                                }}
                                   className={'absolute top-0 right-0 p-2 bg-white bg-opacity-50 hover:bg-opacity-100 transition duration-200'}>x</a>
                                <img src={item.path} alt="" className={"object-cover w-full h-full"}/>
                            </div>
                        );
                    }

                    return (
                        <label htmlFor="photo" key={item.id}
                               className={"flex text-gray-500 text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                            {i+1}
                        </label>
                    );
                })}
            </ReactSortable>

            <input type="file" className="hidden" id="photo"
                   name="photo"
                   multiple={true}
                   onChange={handleChange}/>
        </form>
    )
}
