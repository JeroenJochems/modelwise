import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {Link} from "@inertiajs/react";
import {ArrowRightIcon} from "@heroicons/react/24/solid";
import {ApplicationProgress} from "@/Components/Molecules/ApplicationStatus/ApplicationProgress";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplicationStatus({viewModel}: Props) {
    const {role, listing} = viewModel;

    if (!listing) return null;

    return (
        <Content>
            <div className="grid gap-6">
                <ApplicationProgress listing={listing} />
                <Banner listing={listing} role={role} />
            </div>
        </Content>
    );
}

function Banner({listing, role}: {listing: NonNullable<ModelRoleViewModel['listing']>; role: ModelRoleViewModel['role']}) {
    if (!!listing.hired_at) {
        return (
            <div>
                <H2>Congratulations!</H2>
                <P>You've been hired for this job.</P>
            </div>
        );
    }

    if (!!listing.rejected_at) {
        return (
            <div>
                <H2>Not selected this time</H2>
                <P>The client picked someone else. Better luck on the next role.</P>
            </div>
        );
    }

    if (!!listing.extended_application_at) {
        return (
            <div>
                <H2>Sent to the client</H2>
                <P>You've provided the casting materials. We'll let you know as soon as the client decides.</P>
            </div>
        );
    }

    if (!!listing.shortlisted_at) {
        return (
            <div className="rounded-lg border border-amber-300 bg-amber-50 p-4">
                <H2>You've been shortlisted</H2>
                <P className="mb-3">The client wants to see more before deciding.</P>
                <Link
                    href={route('applications.casting', role.id)}
                    className="inline-flex items-center gap-2 bg-teal text-white px-4 py-2 rounded font-medium hover:bg-teal-700 transition"
                >
                    Send casting materials
                    <ArrowRightIcon className="h-4 w-4" />
                </Link>
            </div>
        );
    }

    return (
        <div>
            <H2>Application sent</H2>
            <P>We're reviewing your application. You'll hear from us as soon as there's news.</P>
        </div>
    );
}
