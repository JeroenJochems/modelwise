import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {formatCents} from "@/Utils/Money";
import {H2} from "@/Components/Typography/H2";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Item} from "@/Components/DescriptionList/Item";
import {H3} from "@/Components/Typography/H3";
import {CtaLink} from "@/Components/CtaLink";
import CleanLayout from "@/Layouts/CleanLayout";
import {JobHeader} from "@/Components/JobHeader";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Show({ viewModel }: Props) {

    const { role } = viewModel;
    const { job } = role;

    const allPhotos = [...role.public_photos, ...job.look_and_feel_photos].map(photo => photo.path_square_face);

    return (
        <CleanLayout photos={allPhotos} header={<JobHeader role={role} />}>

            <div className="px-4 sm:px-0 grid gap-4 mb-8 mx-auto w-full max-w-2xl">

                <P>{ role.description }</P>

                <dl className="grid grid-cols-1 gap-4 grid-cols-2">
                    <Item title={'Fee'} val={`${formatCents(role.fee)}`}/>
                    <Item title={'Buyout'} val={formatCents(role.buyout)} />
                    { !!role.buyout_note && <Item title={'Usage'} val={role.buyout_note} className={"col-span-2 sm:col-span-1"} /> }
                    <Item title={'Travel reimbursement'} val={role.travel_reimbursement_note ?? ""} className={"col-span-2 sm:col-span-1"} />
                </dl>

                { allPhotos.length > 0 && (
                    <div className={"mt-4 grid"}>
                        <H3>Look & feel</H3>

                        <div className={"grid grid-cols-4 gap-4"}>

                            { allPhotos.map((photo) => (
                                <img key={photo} src={photo} />
                            ))}
                        </div>
                    </div>
                )}

                <div>
                    <H3>About the job</H3>
                    <P>{ job.description }</P>
                </div>

                <CtaLink href={route('roles.apply', role.id)} title={"I'm interested and available"} />
            </div>
        </CleanLayout>
    )
}
