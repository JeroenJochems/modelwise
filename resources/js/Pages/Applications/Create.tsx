import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {InlinePhotoUploader} from "@/Components/InlinePhotoUploader";
import ModelMeViewModel = App.ViewModels.ModelMeViewModel;
import {useState} from "react";
import {useForm} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import {H2} from "@/Components/Typography/H2";
import {JobHeader} from "@/Components/JobHeader";
import InputGroupText from "@/Components/Forms/InputGroupText";

type Props = {
    viewModel: RoleApplyViewModel;
    meViewModel: ModelMeViewModel;
}

type Form = {
    role_id: number;
    digitals: Array<Domain.Models.Data.ModelPhotoData>;
    application_photos: Array<Domain.Models.Data.ModelPhotoData>;
    cover_letter: string;
}

export default function Create({ viewModel, meViewModel }: Props) {

    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { role } = viewModel;
    const { job } = role;

    const me = meViewModel.me;

    const { post, data, setData } = useForm<Form>({
        role_id: viewModel.role.id,
        digitals: me.digitals,
        application_photos: [],
        cover_letter: '',
    });

    const allPhotos = [...role.public_photos, ...job.look_and_feel_photos].map(photo => photo.path_square_face);

    return (
        <CleanLayout photos={allPhotos} header={<JobHeader role={role} />}>

            <div className="px-4 sm:px-0 grid gap-4">

                <H1>Apply for this role</H1>

                <div>
                    <H2>Digitals</H2>
                    <P className={"mb-2"}>Are your digitals up-to-date and relevant for this role?</P>

                    <InlinePhotoUploader
                        cols={3}
                        photos={data.digitals}
                        onToggleUploading={setIsUploading}
                        onUpdate={(digitals) => setData(data => ({...data, digitals}))}
                        onAdd={(photo) => setData(data => ({...data, digitals: [...data.digitals, photo]}))}
                    />
                </div>

                <div>
                    <H2>Relevant portfolio photos</H2>
                    <P className={"mb-2"}>Upload your most relevant portfolio photos that will get you selected for this role.</P>

                    <InlinePhotoUploader
                        cols={3}
                        photos={data.application_photos}
                        onToggleUploading={setIsUploading}
                        onUpdate={(application_photos) => setData(data => ({...data, application_photos}))}
                        onAdd={(photo) => setData(data => ({...data, application_photos: [...data.application_photos, photo]}))}
                    />
                </div>


                <InputGroupText
                    title="Is there anything you'd like to add to your application?"
                    multiline={true}
                    onChange={value => setData('cover_letter', value)}
                />


                <PrimaryButton onClick={submit} className={"mb-8"} disabled={isSubmitting || isUploading}>
                    { isSubmitting ? "Please wait..." : "Submit application"}
                </PrimaryButton>
            </div>
        </CleanLayout>
    );

    function submit() {
        post(route('roles.apply.store', viewModel.role.id));
    }
}
