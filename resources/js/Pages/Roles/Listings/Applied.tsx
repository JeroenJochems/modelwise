import {P} from "@/Components/Typography/p";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {H3} from "@/Components/Typography/H3";
import React from "react";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {JobHeader} from "@/Components/JobHeader";
import ModelRoleViewModel = App.ViewModels.ModelRoleViewModel;

type Props = {
    viewModel: ModelRoleViewModel
}

export default function Applied({ viewModel }: Props) {
    return (
        <DashboardLayout>
            <Content>
                <JobHeader viewModel={viewModel} />
                <H3>Application successful</H3>
                <P>Thanks for applying to this role. We'll present your profile to the client and will get back with you soon.</P>
            </Content>
        </DashboardLayout>
    )
}
