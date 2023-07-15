import {Head, Link} from '@inertiajs/react';
import { PageProps } from '@/types';
import CleanLayout from "@/Layouts/CleanLayout";

export function link(route: string, title: string, as: string = "a", method: "get"|"post" = "get") {
    return (
        <Link as={as} method={method} href={route} className={"flex justify-between mb-4"}>
            <span>{title}</span>
            <span>&rarr;</span>
        </Link>
    )
}

export default function Dashboard({ auth }: PageProps) {
    return (
        <CleanLayout>
            <Head title="Dashboard" />

            <h1 className={"text-4xl mb-4"}>Dashboard</h1>

            { link(route('account.index'), "My profile")}
            { link(route('jobs'), "My shortlisted jobs")}
            { link(route('logout'), "Log out", "button", "post")}


        </CleanLayout>

    );
}
