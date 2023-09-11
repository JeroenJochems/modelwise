import {Head, Link} from '@inertiajs/react';
import { PageProps } from '@/types';
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import DashboardViewModel = App.ViewModels.DashboardViewModel;
import {Invites} from "@/Components/Invites";
import {OpenApplications} from "@/Components/OpenApplications";
import {Hires} from "@/Components/Hires";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {RecentlyViewedRoles} from "@/Components/RecentlyViewedRoles";

export function link(route: string, title: string, as: string = "a", method: "get"|"post" = "get") {
    return (
        <Link as={as} method={method} href={route} className={"flex w-full justify-between mb-4"}>
            <span>{title}</span>
            <span>&rarr;</span>
        </Link>
    )
}

type Props = { vm: DashboardViewModel } & PageProps


export default function Dashboard(props: Props) {

    const { openInvites, openApplications, hires, recentlyViewedRoles } = props.vm;
    const isEmpty = openInvites.length === 0 && openApplications.length === 0 && hires.length === 0;

    return (
        <DashboardLayout>
            <H1 className={"mt-16 sm:mt-24 mb-8"}>Welcome {props.auth.user.first_name}</H1>
            <div className={"grid gap-8"}>
                { isEmpty && <div className={"p-12 sm:p-16 text-center border border-dashed border-[6px] rounded-lg border-gray-300"}>This is where you'll find your job invites and applications.</div>}
                <RecentlyViewedRoles roles={recentlyViewedRoles} />
                <Invites roles={openInvites} />
                <OpenApplications roles={openApplications} />
                <Hires roles={hires} />

            </div>
        </DashboardLayout>

    );
}
