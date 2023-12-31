import {H2} from "@/Components/Typography/H2";
import {BackLink} from "@/Components/BackLink";
import {H1} from "@/Components/Typography/H1";

type Props = {
    step: number;
    totalSteps?: number;
    backLink?: string;
    children?: React.ReactNode;
    isOnboarding?: boolean;
}

export const Header = ({step, children, isOnboarding }: Props) => {

    const onboardingPages = [
        { step: 2, route: route("onboarding.personal-details") },
        { step: 3, route: route("onboarding.profile-picture") },
        { step: 4, route: route("onboarding.portfolio") },
        { step: 5, route: route("onboarding.digitals") },
        { step: 6, route: route("onboarding.socials") },
        { step: 7, route: route("onboarding.characteristics") },
        { step: 8, route: route("onboarding.exclusive-countries") },
        { step: 9, route: route("onboarding.professional-experience") },
    ]

    const totalSteps = onboardingPages.length+1;

    const backLink = onboardingPages.find(page => page.step === step - 1)?.route

    return (
        <>
            { isOnboarding ? (
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
            ) : (
                <div className={"mb-4"}>
                    <BackLink href={route("account.index")} />
                </div>
            )}
            {children}
        </>
    );
}
