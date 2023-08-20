import {Head, Link} from '@inertiajs/react';
import { PageProps } from '@/types';
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Tabs} from "@/Components/Tabs";

export function link(route: string, title: string, as: string = "a", method: "get"|"post" = "get") {
    return (
        <Link as={as} method={method} href={route} className={"flex w-full justify-between mb-4"}>
            <span>{title}</span>
            <span>&rarr;</span>
        </Link>
    )
}

export default function Dashboard({ auth }: PageProps) {
    return (
        <CleanLayout>
            <Head title="Dashboard" />

            <H1>Dashboard</H1>

            { link(route('account.index'), "Profile")}
            { link(route('invites'), "Invites")}
            { link(route('applications'), "Applications")}
            { link(route('hires'), "Hires")}
            { link(route('logout'), "Log out", "button", "post")}

        </CleanLayout>

    );
}
