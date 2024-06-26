import {H2} from "@/Components/Typography/H2";
import {DashboardRole} from "../Organisms/DashboardRole";
import {RoleData} from "@/types/generated";

type Props = {
    roles: RoleData[]
}

export function RecentlyViewedRoles({ roles }: Props) {

    return roles.length > 0 &&
        <div>
            <H2>Recently viewed roles</H2>
            <ul className={"mb-8 mt-4"}>
                {roles.map(role =>
                    <DashboardRole role={role} key={role.id} />
                )}
            </ul>
        </div>
}
