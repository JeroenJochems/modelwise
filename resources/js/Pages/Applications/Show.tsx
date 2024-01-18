import DashboardLayout from "@/Layouts/DashboardLayout";
import React from "react";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {JobHeader} from "@/Components/JobHeader";
import ModelRoleViewModel = App.ViewModels.ModelRoleViewModel;

type Props = {
    viewModel: ModelRoleViewModel
}

export default function Stored({ viewModel }: Props) {

    return (
        <DashboardLayout>
            <Content>
                <JobHeader viewModel={viewModel} />
            </Content>
        </DashboardLayout>
    )
}
