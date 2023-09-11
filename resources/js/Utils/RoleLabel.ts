export function getRoleLabel(role: Domain.Jobs.Data.RoleData) {

    const hasApplied = role.my_applications && role.my_applications.length > 0;
    const isInvited = role.my_invites && role.my_invites.length > 0;

    if (hasApplied) {

        const isHired = role.my_applications && role.my_applications.some(application => application.hire !== null);
        const isRejected = role.my_applications && role.my_applications.some(application => application.rejection !== null);

        if (isHired) return "Hired";
        if (isRejected) return "Not hired"

        return "Application pending";
    }

    if (isInvited) return "Invited";

    return "Open";
}
