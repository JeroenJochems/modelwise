import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";
import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {formatCents} from "@/Utils/Money";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Show({ viewModel }: Props) {

    const { role } = viewModel;
    const { job } = role;

    console.log(role);


    return (
        <CleanLayout>
            <p className={"text-teal"}>Job description</p>
            <h1 className={'text-4xl'}>{job.title}</h1>
            <p>{job.description}</p>
            <p>{!!job.brand && job.brand.name}</p>

            <hr />

            <p>Role: { role.name }</p>
            <p>Fee: { formatCents(role.fee) }</p>
            { !!role.fee_note && (
                <p>Fee note: { role.fee_note }</p>
            )}

            <p>Buyout: { formatCents(role.buyout) }</p>

            { !!role.buyout_note && (
                <p>Buyout note: { role.buyout_note }</p>
            )}
            { !!role.travel_reimbursement_note && (
                <p>Travel reimbursement: { role.travel_reimbursement_note }</p>
            )}

            <Link href={route('roles.apply', role.id)} className={"bg-teal rounded block text-center mt-2 p-2 text-white"}>
                Apply
            </Link>
        </CleanLayout>
    )
}
