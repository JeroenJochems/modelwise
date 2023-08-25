import {Link} from "@inertiajs/react";

export function LinkButton({href, caption}: {href: string, caption: string}) {

    return (
        <Link as={"button"} href={href} className={"block w-full bg-teal text-white rounded-lg p-4 mt-4 text-center text-sm"}>
            { caption}
        </Link>
    )
}
