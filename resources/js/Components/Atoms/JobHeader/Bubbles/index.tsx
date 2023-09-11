import {HTMLAttributes} from "react";

export function Bubbles({ children }: HTMLAttributes<HTMLDivElement>) {

    return <div className={"mt-4 flex flex-row items-center"}>
        {children }
    </div>
}
