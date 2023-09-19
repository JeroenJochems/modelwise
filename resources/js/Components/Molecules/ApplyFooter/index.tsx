import {CtaLink} from "@/Components/CtaLink";
import {Heart} from "@/Components/Icons/Heart";
import {Cross} from "@/Components/Icons/Cross";
import RoleData = Domain.Jobs.Data.RoleData;

type Props = {
    isInvited: boolean
    hasApplied: boolean
    role: RoleData
}

export function ApplyFooter({role}: Props) {

    const hasApplied = !!role.my_application;
    const isInvited = role.my_invites?.length > 0;

    if (hasApplied) {

        const isHired = role.my_application?.hire
        const isRejected = role.my_application?.is_rejected

        if (hasApplied) {
            return <div className={"py-4"}>
                {isHired && <p>Congratulations! You have been hired for this role.</p>}
                {isRejected && <p>Unfortunately you have not been selected for this role.</p>}
                {!isHired && !isRejected &&
                    <p>You have applied for this role. We will let you know if you are selected.</p>}
            </div>
        }
    }

    return <>
        {isInvited && (
            <div className={"flex"}>
                <CtaLink href={route('roles.apply', role.id)} icon={<Heart/>} className={'w-4/5 mr-4 mb-4'}
                         title={"I'm interested"}/>
                <CtaLink href={route('roles.pass.create', role.id)} icon={<Cross/>} variant={"negative"}
                         className={'w-1/5 mb-4'} title={"Pass"}/>
            </div>
        )}

        {!isInvited && (
            <CtaLink href={route('roles.apply', role.id)} title={"I'm interested"}/>
        )}
    </>
}
