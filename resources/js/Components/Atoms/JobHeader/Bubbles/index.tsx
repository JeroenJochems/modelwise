import {HTMLAttributes} from "react";

export function Bubbles({ children }: HTMLAttributes<HTMLDivElement>) {

    return <div className={"mt-4 grid grid-cols-2 gap-4 flex-row items-center"}>
        {children }
    </div>
}
