import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";

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
            <div className={"grid grid-cols-1 gap-4"}>

                <Link href={route("dashboard")} className={"w-16"}>
                    &lt; Back
                </Link>

                <h1 className={"text-4xl"}>My account</h1>
                { link(route('account.personal-details'), 'Personal Details') }
                { link(route('account.profile-picture'), 'Profile picture') }
                { link(route('account.portfolio'), 'Portfolio') }
                { link(route('account.digitals'), 'Digitals') }
                { link(route('account.socials'), 'Socials') }
                { link(route('account.characteristics'), 'Characteristics') }
                { link(route('account.exclusive-countries'), 'Exclusive countries') }
            </div>
        </CleanLayout>
    );
}
