import {HTMLAttributes } from "react";

export function HeaderBar({ children }: HTMLAttributes<HTMLDivElement>) {

    return <div className={"flex p-4 pt-12 flex-col"}>
        {children}
    </div>
}
