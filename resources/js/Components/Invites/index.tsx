import InviteData = Domain.Jobs.Data.InviteData;
import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {DashboardRole} from "../Organisms/DashboardRole";
import RoleData = Domain.Jobs.Data.RoleData;

type Props = {
    roles: RoleData[]
}

export function Invites({ roles }: Props) {

    return roles.length > 0 &&
        <div>
            <H2>Your invites</H2>
            <ul className={"mb-8 mt-4"}>
                {roles.map(role =>
                    <DashboardRole role={role} key={role.id} />
                )}
            </ul>
        </div>
}
