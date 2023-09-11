import {PropsWithChildren} from "react";

export function Content({ children}: PropsWithChildren) {
    return <div className={"max-w-6xl bg-white rounded-lg mx-auto w-full leading-relaxed grid gap-8"}>
        { children }
    </div>
}
