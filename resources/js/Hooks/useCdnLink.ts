import {usePage} from "@inertiajs/react";

type cdnLinkProps = {
    path: string;
    style: "face_square" | "orginal";
}

export function useCdnLink() {

    const { cdn_url } = usePage().props;


    function cdnLink(path: string, style: "face_square" | "original" = "original") {

        let format = "?twic=v1/cover=1:1/resize=600/focus=auto";

        return `${cdn_url}${path}${format}`;
    }

    return cdnLink;
}
