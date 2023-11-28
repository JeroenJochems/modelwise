import {H2} from "@/Components/Typography/H2";
import {DashboardRole} from "@/Components/Organisms/DashboardRole";
import RoleData = Domain.Jobs.Data.RoleData;

type Props = {
    roles: RoleData[]
}

export function Hires({ roles }: Props) {

    return roles.length > 0 &&
        <div>
            <H2>Your hires</H2>
            <ul className={"mt-4 mb-8"}>
                {roles.map(role =>
                    <DashboardRole role={role} key={role.id} />
                )}
            </ul>
        </div>
}
