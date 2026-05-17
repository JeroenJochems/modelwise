import DashboardLayout from "@/Layouts/DashboardLayout";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {Link} from "@inertiajs/react";
import {ArrowLeftIcon} from "@heroicons/react/24/solid";
import {JobHeader} from "@/Components/JobHeader";
import {ShortlistedSteps} from "@/Components/Molecules/ApplicationStatus/ShortlistedSteps";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel;
};

export default function Casting({viewModel}: Props) {
    const {role, listing} = viewModel;

    if (!listing) return null;

    return (
        <DashboardLayout>
            <div className="flex-grow">
                <JobHeader viewModel={viewModel} />

                <Content>
                    <Link
                        href={route('roles.show', role.id)}
                        className="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 mb-4"
                    >
                        <ArrowLeftIcon className="h-4 w-4" />
                        Back to role
                    </Link>

                    <ShortlistedSteps listing={listing} role={role} />
                </Content>
            </div>
        </DashboardLayout>
    );
}
