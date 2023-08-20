import {Link} from "@inertiajs/react";
import {RightArrow} from "@/Components/Icons/RightArrow";

type Props = {
    href: string;
    title: string;
}

export function CtaLink({href, title}: Props) {
    return (
        <Link href={href} className={"bg-teal justify-between rounded-lg flex text-center mt-2 mb-12 p-4 text-white"}>
            <span>&nbsp;</span>
                {title}
            <RightArrow />
        </Link>
        );
}
