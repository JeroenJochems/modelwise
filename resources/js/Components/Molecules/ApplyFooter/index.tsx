import {CtaLink} from "@/Components/CtaLink";
import {Heart} from "@/Components/Icons/Heart";
import {Cross} from "@/Components/Icons/Cross";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplyFooter({viewModel}: Props) {

    const { role, hasApplied, listing } = viewModel;

    if (hasApplied) {

        const isHired = !!listing?.hired_at
        const isRejected = !!listing?.rejected_at

        if (hasApplied) {
            return <div className={"py-4 pb-safe"}>
                {isHired && <p>Congratulations! You have been hired for this role.</p>}
                {isRejected && <p>Unfortunately you have not been selected for this role.</p>}
                {!isHired && !isRejected &&
                    <p>You have applied for this role. We will let you know if you are selected.</p>}
            </div>
        }
    }

    return <>
        <div className={"flex"}>
            <CtaLink id={"apply"} href={route('applications.create', role.id)} icon={<Heart/>} className={'w-full mr-4'}>
                {"I'm interested"}
            </CtaLink>
        </div>
    </>
}
