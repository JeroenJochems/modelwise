import {H2} from "@/Components/Typography/H2";
import {H1} from "@/Components/Typography/H1";
import {Label} from "@/Components/Atoms/Label";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel
}

export function JobHeader({ viewModel }: Props ) {

    const { role } = viewModel;

    return (
        <div className={"grid gap-8 mt-4 mb-4"}>
            <div>
                <H2 className={"mt-4 whitespace-pre-wrap"}>
                    {role.name}
                </H2>
                <H1>{role.job.title}</H1>
            </div>
        </div>
    )
}
