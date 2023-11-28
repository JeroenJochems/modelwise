import {Link} from "@inertiajs/react";
import {RightArrow} from "@/Components/Icons/RightArrow";
import {HTMLAttributes, ReactElement} from "react";
import { Method } from '@inertiajs/core';

type Props = {
    href: string;
    method?: Method;
    title?: ReactElement|string;
    variant?: "primary" | "negative";
    icon?: ReactElement|boolean;
}

export function CtaLink({href, variant="primary", method="get", title, className='', icon=<RightArrow />, children}: Props & HTMLAttributes<HTMLDivElement>) {

    const backgroundColor = {
        primary: 'bg-teal text-white',
        negative: 'bg-teal-100 border border-teal text-teal',
    }


    return (
        <Link method={method} href={href} className={`${className} ${backgroundColor[variant]} justify-between font-semibold rounded-lg flex text-center p-4`}>
            <span className={"hidden"}>&nbsp;</span>
            {children || title}
            {icon ? icon : <span>&nbsp;</span>}
        </Link>
        );
}
