import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import DashboardLayout from "@/Layouts/DashboardLayout";
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
            </Content>
        </DashboardLayout>
    )
}
