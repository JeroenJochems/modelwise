import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";
import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {formatCents} from "@/Utils/Money";
import {H2} from "@/Components/Typography/H2";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Item} from "@/Components/DescriptionList/Item";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Show({ viewModel }: Props) {

    const { role } = viewModel;
    const { job } = role;

    console.log(role);


    return (
        <CleanLayout>


            <div>
                <div className="px-4 sm:px-0 grid gap-4 mb-8">
                    <H1>{job.title}</H1>
                    { !!job.brand && (
                        <P className={"font-bold"}>{ job.brand.name}</P>
                    )}
                    <P className={""}>{ job.description }</P>

                    { job.look_and_feel_photos.length > 0 && (
                        <div className={"grid grid-cols-3 gap-4"}>
                            { job.look_and_feel_photos.map((photo) => (
                                <img src={`${photo.path}?w=300&h=300&fit=crop&crop=faces`} className={"mb-4"} />
                            ))}
                        </div>
                    )}
                </div>

                <H2>Role: { role.name }</H2>
                <P className={"mb-4"}>{ role.description }</P>

                { role.public_photos.length > 0 && (
                    <div className={"grid grid-cols-3 gap-4"}>
                        { role.public_photos.map((photo) => (
                            <img src={`${photo.path}?w=300&h=300&fit=crop&crop=faces`} className={"mb-4"} />
                        ))}
                    </div>
                )}

                <div className="">
                    <dl className="grid grid-cols-1 sm:grid-cols-2">
                        <Item var={'Shoot date'} val={role.start_date}/>
                        { role.end_date
                            ? <Item var={'Till'} val={role.end_date}/>
                            : <Item var={''} val={''}/>
                        }

                        <Item var={'Fee'} val={`${formatCents(role.fee)}`}/>
                        <Item var={'Buyout'} val={formatCents(role.buyout)} line2={role.buyout_note}/>
                        { !!role.buyout_note && <Item var={'Buyout description'} val={role.buyout_note}/> }
                        <Item var={'Travel reimbursement'} val={role.travel_reimbursement_note ?? ""} />
                    </dl>
                </div>
            </div>

            <Link href={route('roles.apply', role.id)} className={"bg-teal rounded block text-center mt-2 mb-12 p-2 text-white"}>
                Apply
            </Link>
        </CleanLayout>
    )
}
