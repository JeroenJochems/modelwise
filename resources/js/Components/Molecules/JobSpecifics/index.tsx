import {Item} from "@/Components/DescriptionList/Item";
import {formatCents} from "@/Utils/Money";
import {Bubble} from "@/Components/Atoms/JobHeader/Bubbles/Bubble";
import {CalendarDays} from "@/Components/Icons/CalendarDays";
import {formatDate} from "@/Utils/Dates";
import {Globe} from "@/Components/Icons/Globe";

type Props = {
    role: Domain.Jobs.Data.RoleData
    className?: string
}

export function JobSpecifics({ role, className='grid grid-cols-2 gap-4 sm:grid-cols-6' }: Props) {

    return (
        <dl className={className}>
            <Item title={'Fee'} val={`${formatCents(role.fee)}`}/>
            <Item title={'Buyout'} val={formatCents(role.buyout)} />
            <Item title={'Shoot'} val={ formatDate(role.start_date) } />
            <Item title={'Location'} val={ role.job.location } />
            <Item title={'Travel reimbursement'} val={role.travel_reimbursement_note ?? ""} className={"col-span-2"} />
        </dl>
    );
}
