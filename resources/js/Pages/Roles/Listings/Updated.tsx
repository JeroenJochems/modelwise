import {P} from "@/Components/Typography/p";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {H3} from "@/Components/Typography/H3";
import React from "react";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {JobHeader} from "@/Components/JobHeader";
import {CtaLink} from "@/Components/CtaLink";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel
}

export default function Updated({ viewModel }: Props) {

    return (
        <DashboardLayout>
            <Content>
                <JobHeader viewModel={viewModel} />
                <H3>Application updated</H3>
                <P>Thanks for providing the additional info. We'll present it to the client and will get back with you soon.</P>

                <CtaLink href={route("dashboard")} title={"Continue to dashboard"} />
            </Content>
        </DashboardLayout>
    )
}
