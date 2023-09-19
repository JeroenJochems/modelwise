import {DashboardRole} from "../Organisms/DashboardRole";
import RoleData = Domain.Jobs.Data.RoleData;
import {H2} from "@/Components/Typography/H2";

type Props = {
    roles: RoleData[]
}

export function OpenApplications({ roles }: Props) {

    return roles.length > 0 &&
        <div>
            <H2>Your applications waiting for response</H2>
            <ul className={"mb-8 mt-4"}>
                {roles.map(role =>
                    <DashboardRole role={role} key={role.id} />
                )}
            </ul>
        </div>
}
