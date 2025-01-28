import {H2} from "@/Components/Typography/H2";
import {DashboardRole} from "../Organisms/DashboardRole";
import {RoleData} from "@/types/generated";

type Props = {
    roles: RoleData[]
    passedRoles: number[]
}

export function RecentlyViewedRoles({ passedRoles, roles }: Props) {

    return roles.length > 0 &&
        <div>
            <H2>Recently viewed roles</H2>
            <ul className={"mb-8 mt-4"}>
                {roles.map(role =>
                    <DashboardRole hasPassed={passedRoles.includes(role.id)} role={role} key={role.id} />
                )}
            </ul>
        </div>
}
