import {HTMLAttributes } from "react";

export function Bubble({ children, className }: HTMLAttributes<HTMLDivElement>) {
    return <div className={"text-center bg-teal-100 text-teal pl-2 pr-3 py-1 text-xs flex justify-center sm:py-4 items-center rounded-lg"}>
        {children }
    </div>
}
