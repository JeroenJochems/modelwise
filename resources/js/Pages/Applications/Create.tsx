import RoleApplyViewModel = App.ViewModels.RoleApplyViewModel;
import {P} from "@/Components/Typography/p";
import {InlinePhotoUploader} from "@/Components/InlinePhotoUploader";
import ModelMeViewModel = App.ViewModels.ModelMeViewModel;
import {ChangeEvent, useState} from "react";
import {useForm, usePage} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import {H2} from "@/Components/Typography/H2";
import {JobHeader} from "@/Components/JobHeader";
import InputGroupText from "@/Components/Forms/InputGroupText";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {Content} from "@/Layouts/DashboardLayout/Content";
import InputError from "@/Components/InputError";

type Props = {
    viewModel: RoleApplyViewModel;
    meViewModel: ModelMeViewModel;
}

type Form = {
    role_id: number;
    digitals: Array<Domain.Profiles.Data.ModelPhotoData>;
    photos: Array<Domain.Profiles.Data.ModelPhotoData>;
    cover_letter: string;
    height: number;
    chest: number;
    waist: number;
    hips: number;
    shoe_size: number;
    brand_conflicted: string;
    available_dates: Array<string>;
}

export default function Create({ viewModel, meViewModel }: Props) {

    const { errors } = usePage().props

    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { role, shootDates } = viewModel;
    const me = meViewModel.me;

    const { post, data, setData } = useForm<Form>({
        role_id: viewModel.role.id,
        digitals: me.digitals,
        photos: [],
        height: me.height,
        chest: me.chest,
        waist: me.waist,
        hips: me.hips,
        shoe_size: me.shoe_size,
        cover_letter: '',
        available_dates: [],
        brand_conflicted: '',
    });

    function submit() {
        setIsSubmitting(true);
        post(route('roles.apply.store', viewModel.role.id));
    }

    function handleAvailability(event: ChangeEvent<HTMLInputElement>) {
        event.target.checked
            ? setData('available_dates', [...data.available_dates, event.target.value])
            : setData('available_dates', data.available_dates.filter((item) => item !== event.target.value));
    }

    return (
        <DashboardLayout>

            <JobHeader role={role} />

            <Content>
                <H2 className={"mt-8"}>Apply for this role</H2>

                { role.fields.digitals && (
                    <div>
                        <H2>Digitals</H2>
                        <P className={"mb-2"}>Are your digitals up-to-date and relevant for this role?</P>

                        <InlinePhotoUploader
                            colsOnMobile={3}
                            cols={6}
                            slots={6}
                            photos={data.digitals}
                            error={errors.digitals}
                            onToggleUploading={setIsUploading}
                            onUpdate={(digitals) => setData(data => ({...data, digitals}))}
                            onAdd={(photo) => setData(data => ({...data, digitals: [...data.digitals, photo]}))}
                        />
                    </div>
                )}

                <div>
                    <H2>Relevant photos</H2>
                    <P className={`mb-2`}>Select and sort your most relevant photos that will get you hired for this role.</P>

                    <InlinePhotoUploader
                        error={errors.photos}
                        photos={data.photos}
                        onToggleUploading={setIsUploading}
                        onUpdate={(photos) => setData(data => ({...data, photos}))}
                        onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                    />
                </div>

                { (role.fields.height || role.fields.chest || role.fields.waist || role.fields.hips || role.fields.shoe_size) && (
                    <div>
                        <H2>Sizes</H2>
                        <P className={"mb-2"}>The following sizes are relevant for this job. Is everything still up to date?</P>

                        <div className={"grid grid-cols-2 md:grid-cols-3 gap-4"}>
                            { role.fields.height && (
                                <InputGroupText
                                    title="Height (cm)"
                                    placeholder="cm"
                                    type={"number"}
                                    value={data.height}
                                    onChange={value => setData("height", parseInt(value))}
                                />
                            )}

                            { role.fields.chest && (
                                <InputGroupText
                                    title="Chest (cm)"
                                    type={"number"}
                                    value={data.chest}
                                    onChange={value => setData("chest", parseInt(value))}
                                />
                            )}

                            { role.fields.waist && (
                                <InputGroupText
                                    title="Waist (cm)"
                                    type={"number"}
                                    value={data.waist}
                                    onChange={value => parseInt(value)}
                                />
                            )}

                            { role.fields.hips && (
                                <InputGroupText
                                    title="Hips (cm)"
                                    type={"number"}
                                    value={data.hips}
                                    onChange={value => parseInt(value)}
                                />
                            )}

                            { role.fields.shoe_size && (
                                <InputGroupText
                                    title="Shoe size (eu)"
                                    type={"number"}
                                    value={data.shoe_size}
                                    onChange={value => parseInt(value)}
                                />
                            )}
                        </div>
                    </div>
                )}

                <div>
                    <H2>Availability</H2>
                    <P className={"mb-2"}>
                        Please confirm your availability for the following shoot dates. If not all are available we will contact you to discuss.</P>
                        { shootDates.map((shootDate) => (
                            <label className={"flex flex-row text-teal items-center mb-2"} key={shootDate}>
                                <input type="checkbox" onChange={handleAvailability} name={"available"} value={shootDate} className={"mr-2"} />
                                <span>{ new Date(shootDate).toLocaleDateString() }</span>
                            </label>
                        ))
                    }
                    <InputError message={errors.available_dates} />
                </div>

                <InputGroupText
                    title="Have you worked with a competing brand in the last 3 years? If so, please describe."
                    multiline={true}
                    onChange={value => setData('brand_conflicted', value)}
                />

                <InputGroupText
                    title="Is there anything you'd like to add to your application?"
                    multiline={true}
                    onChange={value => setData('cover_letter', value)}
                />

                <PrimaryButton onClick={submit} className={"mb-8"} disabled={isUploading}>
                    { isSubmitting ? "Please wait..." : "Submit application"}
                </PrimaryButton>
            </Content>
        </DashboardLayout>
    );

}
