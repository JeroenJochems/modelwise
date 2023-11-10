import {usePage} from "@inertiajs/react";

type cdnLinkProps = {
    path: string;
    style: "face_square" | "orginal";
}

export function useCdnLink() {

    const { cdn_url } = usePage().props;


    function cdnLink(path: string, style: "face_square" | "original" = "original") {

        let format = "?fm=auto&w=600&h=600&fit=crop";

        if (style === "face_square") {
            format = "?fm=auto&w=600&h=600&fit=crop&crop=faces";
        }

        return `${cdn_url}${path}${format}`;
    }

    return cdnLink;
}
