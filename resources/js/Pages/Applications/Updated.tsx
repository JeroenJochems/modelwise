import {P} from "@/Components/Typography/p";
import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import DashboardLayout from "@/Layouts/DashboardLayout";
import {H3} from "@/Components/Typography/H3";
import React from "react";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {JobHeader} from "@/Components/JobHeader";
import {CtaLink} from "@/Components/CtaLink";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Updated({ viewModel }: Props) {

    const { role } = viewModel;

    return (
        <DashboardLayout>
            <Content>
                <JobHeader role={role} />
                <H3>Application updated</H3>
                <P>Thanks for providing the additional info. We'll present it to the client and will get back with you soon.</P>

                <CtaLink href={route("dashboard")} title={"Continue to dashboard"} />
            </Content>
        </DashboardLayout>
    )
}
