import {Head, Link} from '@inertiajs/react';
import { PageProps } from '@/types';
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import DashboardViewModel = App.ViewModels.DashboardViewModel;
import {Invites} from "@/Components/Invites";
import {OpenApplications} from "@/Components/OpenApplications";
import {Hires} from "@/Components/Hires";

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

    const { openInvites, openApplications, hires } = props.vm;

    return (
        <CleanLayout>
            <Head title="Dashboard" />

            <H1>Welcome back { props.auth.user.first_name }</H1>

            <div className={"grid gap-8"}>
                <Invites invites={openInvites} />
                <OpenApplications applications={openApplications} />
                <Hires hires={hires} />
                <hr />
                { link(route('account.index'), "Profile")}
                { link(route('logout'), "Log out", "button", "post")}
            </div>



        </CleanLayout>

    );
}
