import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {ExtendedApplicationForm} from "@/Components/Molecules/ApplicationStatus/ExtendedApplicationForm";
import RoleData = Domain.Jobs.Data.RoleData;

type Props = {
    role: RoleData;
}

export function ApplicationStatus({ role }: Props) {

    const application = role.my_application
    const isShortlisted = application.is_shortlisted;
    const isHired = !!application.hire;
    const isRejected = application.is_rejected;

    if (isHired) {
        return (
            <Content>
                <H2>Congratulations!</H2>
                <P>You've been hired for this job!</P>
            </Content>
        )
    }

    if (isRejected) {
        return (
            <Content>
                <H2>Missed</H2>
                <P>Sorry, you were not hired for this role. Better luck next time!</P>
            </Content>
        )
    }

    if (isShortlisted) {
        return (
            <Content>
                <H2>You've been shortlisted!</H2>

                { application.casting_photos.length > 0
                    ? <>You have provided additional casting information. This will now be presented to the client. We'll keep you posted once the client has made a decision.</>
                    : <>
                        <P>You've been pre-selected for this job. The client has requested additional information to make a hiring decision.</P>
                        <P>Provide the requested information below to increase your chances of being hired.</P>
                        <ExtendedApplicationForm role={role} />
                    </>}
            </Content>
        )
    }


    return (<Content>
                <P>Thank you for applying to this job!</P>
                <P>We will review your application and get back to you as soon as possible.</P>
                <P>Good luck!</P>
            </Content>
        )
}
