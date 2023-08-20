import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {Link} from "@inertiajs/react";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Stored({ viewModel }: Props) {

    const { role } = viewModel;
    const { job } = role;

    const allPhotos = [...role.public_photos, ...job.look_and_feel_photos].map(photo => photo.path_square_face);

    return (
        <CleanLayout photos={allPhotos}>
            <div className={"grid gap-4 mt-16"}>
                <H1>Application successful</H1>
                <P>Thanks for applying to this role. We'll present your profile to the client and will get back with you soon.</P>
                <Link href={route("dashboard")}>Return to dashboard</Link>
            </div>
        </CleanLayout>
    )
}
