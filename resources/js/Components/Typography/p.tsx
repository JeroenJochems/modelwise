import {HTMLAttributes, useState } from "react";

type Props = {
    lineClamp?: number
} & HTMLAttributes<HTMLParagraphElement>


export function P({ children, className = '', lineClamp }: Props) {
    const [clicked, setClicked] = useState(false);
    const baseClasses = 'text-gray-700 text-normal';

    const handleToggleClick = () => {
        setClicked(!clicked);
    };

    const conditionalClasses = lineClamp && !clicked ? ` ${baseClasses} line-clamp-${lineClamp}` : '';

    return (
        <p onClick={handleToggleClick} className={`${baseClasses} ${className}${conditionalClasses}`}>
            {children}
        </p>
    );
}
