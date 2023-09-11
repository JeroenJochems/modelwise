import {PropsWithChildren} from "react";

export function PhotoScroller({ children, photos }: PropsWithChildren & { photos: string[] }) {

    return (
        <div className={"px-4 -mx-4 sm:px-0 sm:mx-0 flex overflow-y-scroll"}>
            { photos.map((photo) => (
                <img className={"h-64 sm:h-96 mr-4 rounded-lg"} key={photo} src={photo} />
            ))}
        </div>
    )
}
