import {ModelRoleProps} from "@/Components/JobHeader";

export function getRoleLabel(role: Domain.Jobs.Data.RoleData) {


    if (role.my_application) {
        if (role.my_application.hire) return "Hired";
        if (role.my_application.is_rejected) return "Rejected";
        if (role.my_application.is_shortlisted) return "Shortlisted";

        return "Application pending";
    }

    if (role.my_passes?.length) return "Passed";

    if (role.my_invites?.length) return "Invited";

    return "Open";
}
