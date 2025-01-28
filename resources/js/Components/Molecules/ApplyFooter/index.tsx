import {CtaLink} from "@/Components/CtaLink";
import {Heart} from "@/Components/Icons/Heart";
import {Cross} from "@/Components/Icons/Cross";
import {ModelRoleViewModel} from "@/types/generated";
import {CheckIcon} from "@heroicons/react/24/outline";
import {CheckCircleIcon} from "@heroicons/react/24/solid/index.js";

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplyFooter({viewModel}: Props) {

    const { role, hasApplied, listing, hasPassed } = viewModel;

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
        <div className={"flex gap-4"}>
            { hasPassed ? (
                <CtaLink id={"apply"} href={route('role.toggle-pass', role.id)} icon={<Cross/>} className={'w-full'}>
                    {"You have passed on this role."}
                </CtaLink>
            ) : (
                <>
                    <CtaLink id={"apply"} href={route('applications.create', role.id)} icon={<Heart/>} className={'w-3/4'}>
                        {"I'm interested"}
                    </CtaLink>
                    <CtaLink id={"reject"} href={route('role.toggle-pass', role.id)} icon={<Cross />} className={'w-1/4'}>
                        {"Pass"}
                    </CtaLink>
                </>
                )
            }
        </div>
    </>
}
