import { HTMLAttributes,} from "react";

export function P({children, className = '' }: HTMLAttributes<HTMLParagraphElement>) {
    return (
        <p className={`text-gray-600 text-sm ` + className}>
            {children}
        </p>
    )
}
