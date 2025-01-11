import {usePage} from "@inertiajs/react";

type cdnLinkProps = {
    path: string;
    style: "face_square" | "orginal";
}

export function useCdnLink() {

    const { cdn_url } = usePage().props;


    function cdnLink(path: string, style: "face_square" | "original" | "large" = "original") {

        let format = `?twic=v1/focus=faces/cover=1:1/resize=${style==="large" ? 1200 : 600}/output=jpeg`;

        let response = path;

        if (!path.includes('https://')) {
            response = `${cdn_url}${response}`;
        }

        if (!path.includes('?twic=')) {
            response = `${response}${format}`;
        }

        return response;
    }

    return cdnLink;
}
