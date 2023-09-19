import {PropsWithChildren} from "react";

export function Content({ children}: PropsWithChildren) {
    return <div className={"max-w-6xl rounded-lg mx-auto w-full leading-relaxed grid gap-4"}>
        { children }
    </div>
}
