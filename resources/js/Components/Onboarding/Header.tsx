import {H2} from "@/Components/Typography/H2";
import {Link} from "@inertiajs/react";
import {ArrowBack} from "@/Components/ArrowBack";
import {BackLink} from "@/Components/BackLink";

type Props = {
    step: number;
    totalSteps?: number;
    backLink?: string;
    children?: React.ReactNode;
    isOnboarding?: boolean;
}

export const Header = ({step, totalSteps=8, children, isOnboarding }: Props) => {

    const onboardingPages = [
        { step: 2, route: route("onboarding.personal-details") },
        { step: 3, route: route("onboarding.profile-picture") },
        { step: 4, route: route("onboarding.portfolio") },
        { step: 5, route: route("onboarding.digitals") },
        { step: 6, route: route("onboarding.socials") },
        { step: 7, route: route("onboarding.characteristics") },
        { step: 8, route: route("onboarding.exclusive-countries") },
    ]

    const backLink = onboardingPages.find(page => page.step === step - 1)?.route

    if (!isOnboarding) {
        return <BackLink href={route("account.index")} />;
    }

    return (
        <div className={"mb-8"}>
            <div className="flex items-center justify-between mb-2">
                <div className={"w-16"}>
                    { !!backLink && <BackLink href={backLink} /> }
                </div>
                <H2 className={"text-center"}>
                    Step {step} of {totalSteps}
                </H2>
                <div className={"w-16"}>

                </div>
            </div>
            <div className="w-full bg-gray-100 h-2 rounded-full">
                <div style={{ width: (step / totalSteps * 100) + '%'}}  className="bg-green h-2 rounded-full"></div>
            </div>
        </div>
    );
}
