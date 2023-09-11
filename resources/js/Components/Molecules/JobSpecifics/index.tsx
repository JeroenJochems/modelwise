import {Item} from "@/Components/DescriptionList/Item";
import {formatCents} from "@/Utils/Money";

type Props = {
    role: Domain.Jobs.Data.RoleData
    className?: string
}

export function JobSpecifics({ role, className='grid grid-cols-2 gap-4 sm:grid-cols-6' }: Props) {

    return (
        <dl className={className}>
            <Item title={'Fee'} val={`${formatCents(role.fee)}`}/>
            <Item title={'Buyout'} val={formatCents(role.buyout)} />
            { !!role.buyout_note && <Item title={'Usage'} val={role.buyout_note} className={"col-span-2"} /> }
            <Item title={'Travel reimbursement'} val={role.travel_reimbursement_note ?? ""} className={"col-span-2"} />
        </dl>
    );
}
