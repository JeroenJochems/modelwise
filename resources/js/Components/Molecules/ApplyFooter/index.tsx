import {CtaLink} from "@/Components/CtaLink";
import {Heart} from "@/Components/Icons/Heart";
import {Cross} from "@/Components/Icons/Cross";
import ModelRoleViewModel = App.ViewModels.ModelRoleViewModel;

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplyFooter({viewModel}: Props) {

    const { role, my_application, hasApplied, hasPassed } = viewModel;

    if (hasApplied) {

        const isHired = my_application?.hire
        const isRejected = my_application?.is_rejected

        if (hasApplied) {
            return <div className={"py-4"}>
                {isHired && <p>Congratulations! You have been hired for this role.</p>}
                {isRejected && <p>Unfortunately you have not been selected for this role.</p>}
                {!isHired && !isRejected &&
                    <p>You have applied for this role. We will let you know if you are selected.</p>}
            </div>
        }
    }

    if (hasPassed) {
        return null;
    }

    return <>
        <div className={"flex"}>
            <CtaLink href={route('roles.apply', role.id)} icon={<Heart/>} className={'w-4/5 mr-4 mb-4'}>
                {"I'm interested"}
            </CtaLink>

            <CtaLink method={"post"} href={route('roles.pass.store', role.id)} icon={<Cross/>} variant={"negative"} className={'w-1/5 mb-4'}>
                <span className={"hidden sm:flex"}>Pass</span>
            </CtaLink>
        </div>
    </>
}
