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
        <div className={"grid gap-8 mt-4 mb-4"}>
            <Label>
                { getRoleLabel(role) }
            </Label>

            <div>
                <H2 className={"mt-4 whitespace-pre-wrap"}>
                    {role.job.brand?.name } { "\n" }
                    {role.name}
                </H2>
                <H1>{job.title}</H1>
            </div>
        </div>
    )

}
