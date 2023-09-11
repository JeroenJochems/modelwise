import {H2} from "@/Components/Typography/H2";
import {H1} from "@/Components/Typography/H1";
import RoleData = Domain.Jobs.Data.RoleData;
import {Globe} from "@/Components/Icons/Globe";
import {CalendarDays} from "@/Components/Icons/CalendarDays";
import {Bubble} from "@/Components/Atoms/JobHeader/Bubbles/Bubble";
import {Bubbles} from "@/Components/Atoms/JobHeader/Bubbles";
import {HeaderBar} from "@/Components/Atoms/JobHeader";
import {formatDate} from "@/Utils/Dates";
import {Label} from "@/Components/Atoms/Label";
import {getRoleLabel} from "@/Utils/RoleLabel";
import {P} from "@/Components/Typography/p";

type Props = {
    role: RoleData;
}

export function JobHeader({ role }: Props ) {

    const { job } = role;

    return (
        <div className={"grid gap-8"}>
            <Label>
                { getRoleLabel(role) }
            </Label>

            <div>
                <H2 className={"mt-4"}>{role.name}</H2>
                <H1>{job.title}</H1>
                <P className={"mt-4"} lineClamp={4}>{ role.description }</P>

                <Bubbles>
                    <Bubble className={"mr-2"}>
                        <CalendarDays className={"mr-1"} /> { formatDate(role.start_date) }
                    </Bubble>

                    <Bubble>
                        <Globe className={"mr-1"} /> { job.location }
                    </Bubble>
                </Bubbles>
            </div>
        </div>
    )

}
