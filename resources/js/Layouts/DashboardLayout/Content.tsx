import {PropsWithChildren} from "react";

export function Content({ children}: PropsWithChildren) {
    return <div className={"max-w-7xl rounded-lg mx-auto w-full leading-relaxed grid gap-12"}>
        { children }
    </div>
}
