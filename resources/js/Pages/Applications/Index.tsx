import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {H3} from "@/Components/Typography/H3";
import ModelMeViewModel = App.ViewModels.ModelMeViewModel;
import {BackLink} from "@/Components/BackLink";


type Props = {
    meViewModel: ModelMeViewModel
}


export default function Index({ meViewModel }: Props) {

    return (
        <CleanLayout>

            <BackLink href={route("dashboard")} />

            <H1>My applications</H1>

            {meViewModel.me.applications.map(application => (
                <div key={application.id} className={"mb-4"}>
                    <H3>Title: { application.role.name } at { application.role.job.title }</H3>

                    <div>Status: { application.status }</div>
                </div>
            ))}

        </CleanLayout>
    )
}
