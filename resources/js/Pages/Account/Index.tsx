import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";
import {H1} from "@/Components/Typography/H1";
import {ArrowBack} from "@/Components/ArrowBack";
import {BackLink} from "@/Components/BackLink";

export function link(route: string, title: string, as: string = "a", method: "get"|"post" = "get") {
    return (
        <Link as={as} method={method} href={route} className={"flex justify-between mb-4"}>
            <span>{title}</span>
            <span>&rarr;</span>
        </Link>
    )
}

export default function Index() {
    return (
        <CleanLayout>
            <BackLink href={route("dashboard")} />

            <H1>My profile</H1>
            { link(route('account.personal-details'), 'Personal Details') }
            { link(route('account.profile-picture'), 'Profile picture') }
            { link(route('account.portfolio'), 'Portfolio') }
            { link(route('account.digitals'), 'Digitals') }
            { link(route('account.socials'), 'Socials') }
            { link(route('account.characteristics'), 'Characteristics') }
            { link(route('account.exclusive-countries'), 'Exclusive countries') }
        </CleanLayout>
    );
}
