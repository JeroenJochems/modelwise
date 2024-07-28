import {Link} from '@inertiajs/react';
import {PageProps} from '@/types';
import {H1} from "@/Components/Typography/H1";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {RecentlyViewedRoles} from "@/Components/RecentlyViewedRoles";
import {DashboardViewModel} from "@/types/generated";
import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {JobSpecifics} from "@/Components/Molecules/JobSpecifics";
import {CtaLink} from "@/Components/CtaLink";
import {useCdnLink} from "@/Hooks/useCdnLink";
import {Bubble} from "@/Components/Atoms/JobHeader/Bubbles/Bubble";
import {Label} from "@/Components/Atoms/Label";

export function link(route: string, title: string, as: string = "a", method: "get" | "post" = "get") {
    return (
        <Link as={as} method={method} href={route} className={"flex w-full justify-between mb-4"}>
            <span>{title}</span>
            <span>&rarr;</span>
        </Link>
    )
}

type Props = { vm: DashboardViewModel } & PageProps


export default function Dashboard(props: Props) {

    const cdnLink = useCdnLink()
    const {listings, recentlyViewedRoles} = props.vm;
    const isEmpty = (listings.length + recentlyViewedRoles.length) === 0

    return (
        <DashboardLayout>
            <H1 className={"mt-16 sm:mt-24 mb-8"}>Welcome {props.auth.user.first_name}</H1>
            <div className={"grid gap-8"}>
                {isEmpty && <div
                    className={"p-12 sm:p-16 text-center border-dashed border-[6px] rounded-lg border-gray-300"}>This
                    is where you'll find your job invites and applications.</div>}
                <RecentlyViewedRoles roles={recentlyViewedRoles}/>

                {listings.map((listing) =>
                    {
                        const hasPhotos = listing.photos !== null && listing.photos.length > 0;

                        console.log(listing.role.job!);

                        return (
                            <li key={listing.id} className={"flex bg-white/95 shadow-outline overflow-hidden rounded-lg"}>
                                <div className={"w-2/3 grid gap-4 p-4 my-4 flex-grow"}>

                                    <Label>{listing.status}</Label>

                                    <H2 className={"font-bold"}>
                                        {listing.role.job!.title}<br />
                                        {listing.role.name}
                                    </H2>
                                    <P lineClamp={3}>{listing.role.job!.description}</P>

                                    <JobSpecifics role={listing.role}/>

                                    <div className={"flex"}>
                                        <CtaLink
                                            title={"Show details"}
                                            className={"bg-teal p-4 rounded text-white"}
                                            href={route("roles.show", listing.role.id)}/>
                                    </div>
                                </div>
                                <div className={"hidden md:flex max-w-xs"}>
                                    {hasPhotos && <img src={cdnLink(listing.photos![0].path, "face_square")}
                                                                 className={"h-full w-full object-cover"}/>}
                                </div>
                            </li>
                        );
                    }
                )}
            </div>
        </DashboardLayout>
    );
}

