export function getRoleLabel(role: Domain.Jobs.Data.RoleData) {

    const hasApplied = role.my_application;

    const isInvited = role.my_invites && role.my_invites.length > 0;

    if (hasApplied) {

        if (role.my_application?.hire) return "Hired";
        if (role.my_application?.is_rejected) return "Rejected";
        if (role.my_application?.is_shortlisted) return "Shortlisted";

        return "Application pending";
    }

    if (isInvited) return "Invited";

    return "Open";
}
