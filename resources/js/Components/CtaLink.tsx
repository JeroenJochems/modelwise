import {Link} from "@inertiajs/react";
import {RightArrow} from "@/Components/Icons/RightArrow";
import {HTMLAttributes, LinkHTMLAttributes, ReactElement} from "react";

type Props = {
    href: string;
    title: ReactElement|string;
    variant?: "primary" | "negative";
    icon?: ReactElement|boolean;
}

export function CtaLink({href, variant="primary", title, className='', icon=<RightArrow />}: Props & HTMLAttributes<HTMLDivElement>) {

    const backgroundColor = {
        primary: 'bg-teal text-white',
        negative: 'bg-teal-100 border border-teal text-teal',
    }


    return (
        <Link href={href} className={`${className} ${backgroundColor[variant]} justify-between font-semibold rounded-lg flex text-center p-4`}>
            <span>&nbsp;</span>
                {title}
            {icon ? icon : <span>&nbsp;</span>}
        </Link>
        );
}
