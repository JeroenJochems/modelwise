import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {ExtendedApplicationForm} from "@/Components/Molecules/ApplicationStatus/ExtendedApplicationForm";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel;
}

export function ApplicationStatus({ viewModel }: Props) {

    const { role, listing } = viewModel;

    if (!listing) return null;

    if (!!listing.hired_at) {
        return (
            <Content>
                <H2>Congratulations!</H2>
                <P>You've been hired for this job!</P>
            </Content>
        )
    }

    if (!!listing.rejected_at) {
        return (
            <Content>
                <H2>Missed</H2>
                <P>Sorry, you were not hired for this role. Better luck next time!</P>
            </Content>
        )
    }

    if (!!listing.extended_application_at) {
        return (
            <Content>
                <H2>Waiting for the client response</H2>
                <>You have provided additional casting information. This will now be presented to the client. We'll keep you posted once the client has made a decision.</>
            </Content>
        )
    }

    if (!!listing.shortlisted_at) {
        return (
            <Content>
                <H2>You've been shortlisted</H2>

                <>
                    <P>The client has requested additional information to make a hiring decision.</P>
                    <P>Please provide the information below to increase your chances of being hired.</P>
                    <ExtendedApplicationForm listing={listing} role={role} />
                </>
            </Content>
        )
    }

    return (<Content>
            <P>Thank you for applying to this role!</P>
            <P>We will review your application and get back to you as soon as possible.</P>
        </Content>
    )
}
