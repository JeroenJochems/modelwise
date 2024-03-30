import {usePage} from "@inertiajs/react";

type cdnLinkProps = {
    path: string;
    style: "face_square" | "orginal";
}

export function useCdnLink() {

    const { cdn_url } = usePage().props;


    function cdnLink(path: string, style: "face_square" | "original" = "original") {

        let format = "cdn-cgi/image/fit=crop,width=600,height=600/";

        return `${cdn_url}${format}${path}`;
    }

    return cdnLink;
}
