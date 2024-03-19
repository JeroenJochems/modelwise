import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {ExtendedApplicationForm} from "@/Components/Molecules/ApplicationStatus/ExtendedApplicationForm";
import ModelRoleViewModel = App.ViewModels.ModelRoleViewModel;

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplicationStatus({ viewModel }: Props) {

    const { role, my_application } = viewModel;

    if (!my_application) return null;

    const isShortlisted = my_application.is_shortlisted;
    const isHired = !!my_application.hire;
    const isRejected = my_application.is_rejected;

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

                { my_application.casting_photos.length > 0
                    ? <>You have provided additional casting information. This will now be presented to the client. We'll keep you posted once the client has made a decision.</>
                    : <>
                        <P>The client has requested additional information to make a hiring decision.</P>
                        <P>Please provide the information below to increase your chances of being hired.</P>
                        <ExtendedApplicationForm application={my_application} role={role} />
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