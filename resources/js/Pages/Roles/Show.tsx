import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {P} from "@/Components/Typography/p";
import {H3} from "@/Components/Typography/H3";
import {JobHeader} from "@/Components/JobHeader";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {PhotoScroller} from "@/Components/Atoms/JobScroller";
import {JobSpecifics} from "@/Components/Molecules/JobSpecifics";
import {ApplyFooter} from "@/Components/Molecules/ApplyFooter";
import {DashboardFooter} from "@/Components/Molecules/DashboardFooter";

type Props = {
    viewModel: RoleApplyViewModel
}

export default function Show({ viewModel }: Props)
{
    const { role, hasApplied, isInvited } = viewModel;
    const { job } = role;

    const isHired = hasApplied && role.my_applications?.some(application => !!application.hire);

    const allPhotos = [...role.public_photos, ...job.look_and_feel_photos].map(photo => photo.path_square_face);
    return (
        <DashboardLayout footer={
            <DashboardFooter className={isHired ? 'bg-green text-white' : ''}>
                <ApplyFooter isInvited={isInvited} hasApplied={hasApplied} role={role} />
            </DashboardFooter>
        }>
            <div className={"flex-grow"}>

                <Content>
                    <JobHeader role={role} />

                    <JobSpecifics role={role} />

                    { job.look_and_feel_photos.length > 0 && (
                        <div className={"mt-4 grid gap-4"}>
                            <H3>Shoot look & feel</H3>
                            <PhotoScroller photos={job.look_and_feel_photos.map(photo => photo.path_square_face)} />
                        </div>
                    )}

                    { role.public_photos.length > 0 && (
                        <div className={"mt-4 grid gap-4"}>
                            <H3>For this role</H3>
                            <PhotoScroller photos={role.public_photos.map(photo => photo.path_square_face)} />
                        </div>
                    )}

                    <div className={""}>
                        <H3>About the job</H3>
                        <P>{ job.description }</P>
                    </div>

                    { !!job.brand?.name && !!job.brand?.description && (
                        <div className={"w-full mb-8"}>
                            <H3>About { job.brand.name }</H3>
                            <P className={"w-full"}>
                                { !!job.brand?.logo && <img className={"ml-4 mb-4 rounded-lg float-right"} src={`${job.brand.logo}?h=120`} /> }
                                { job.brand.description }
                            </P>
                        </div>
                    )}
                </Content>
            </div>
        </DashboardLayout>
    )
}
