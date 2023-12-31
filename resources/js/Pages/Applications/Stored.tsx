import {P} from "@/Components/Typography/p";
import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import DashboardLayout from "@/Layouts/DashboardLayout";
import {H3} from "@/Components/Typography/H3";
import React from "react";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {JobHeader} from "@/Components/JobHeader";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Stored({ viewModel }: Props) {

    const { role } = viewModel;
    const { job } = role;


    return (
        <DashboardLayout>
            <Content>
                <JobHeader role={role} />
                <H3>Application successful</H3>
                <P>Thanks for applying to this role. We'll present your profile to the client and will get back with you soon.</P>
            </Content>
        </DashboardLayout>
    )
}
