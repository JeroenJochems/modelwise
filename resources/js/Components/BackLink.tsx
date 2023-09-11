import {Link} from "@inertiajs/react";

type Props = {
    href: string;
}

export function BackLink({ href }: Props) {
    return (
        <Link href={href} className={"w-16 text-gray-400 flex items-center"}>
            <div className="w-0 h-0 border-t-[5px] border-t-transparent border-r-[9px] border-r-gray-400 border-b-[5px] border-b-transparent mr-2" />
            back
        </Link>
    )
}
