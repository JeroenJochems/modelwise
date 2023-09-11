import {HTMLAttributes } from "react";

export function Bubble({ children, className }: HTMLAttributes<HTMLDivElement>) {
    return <div className={"bg-teal-100 text-teal pl-2 pr-3 py-1 text-xs mr-2 flex items-center rounded-full"}>
        {children }
    </div>
}
