import {ReactElement} from "react";

type Props = {
    slug: string
    isActive?: boolean
    onToggle: (slug: string) => void,
    children: ReactElement | string
}

export function Tag({ isActive, slug, onToggle, children }: Props) {

    return (
        <div onClick={() => onToggle(slug)}
             className={`cursor-pointer select-none font-normal float-left rounded-xl p-1 sm:p-2 mb-2 sm:mb-4 mr-2 sm:mr-4 w-auto border border-gray-400  ${isActive ? 'bg-teal text-white' : 'text-teal'}`}>
            {children}
        </div>
    )
}
