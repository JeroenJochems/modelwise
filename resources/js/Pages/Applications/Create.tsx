import {P} from "@/Components/Typography/p";
import ModelMeViewModel = App.ViewModels.ModelMeViewModel;
import {ChangeEvent } from "react";
import {useForm, usePage} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import {H2} from "@/Components/Typography/H2";
import {JobHeader} from "@/Components/JobHeader";
import InputGroupText from "@/Components/Forms/InputGroupText";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {Content} from "@/Layouts/DashboardLayout/Content";
import InputError from "@/Components/InputError";
import {H1} from "@/Components/Typography/H1";
import {useUploadingFields} from "@/Hooks/useUploadingFields";
import {BaseFile, FileUploader} from "@/Components/FileUploader";
import ModelRoleViewModel = App.ViewModels.ModelRoleViewModel;
import TextArea from "@/Components/TextArea";

type Props = {
    viewModel: ModelRoleViewModel;
    meViewModel: ModelMeViewModel;
}

type Form = {
    role_id: number | string;
    digitals: Array<BaseFile>;
    photos: Array<BaseFile>;
    height: number | string;
    casting_questions: string;
    chest: number | string;
    waist: number | string;
    hips: number | string;
    shoe_size: number | string;
    clothing_size_top: string;
    cover_letter: string;
    available_dates: Array<string>;
    brand_conflicted: string;
}

export default function Create({viewModel, meViewModel}: Props) {

    const {errors} = usePage().props

    const {isUploading, setUploadingField} = useUploadingFields();

    const {role, shootDates} = viewModel;
    const me = meViewModel.me;

    const {post, data, setData, processing, isDirty, hasErrors } = useForm<Form>({
        role_id: viewModel.role.id,
        digitals: me.digitals,
        photos: [],
        casting_questions: '',
        height: me.height || '',
        chest: me.chest || '',
        waist: me.waist || '',
        hips: me.hips || '',
        shoe_size: me.shoe_size || '',
        clothing_size_top: me.clothing_size_top || '',
        cover_letter: '',
        available_dates: [],
        brand_conflicted: ''
    });

    function submit() {
        post(route('roles.apply.store', viewModel.role.id));
    }

    function handleAvailability(event: ChangeEvent<HTMLInputElement>) {
        event.target.checked
            ? setData('available_dates', [...data.available_dates, event.target.value])
            : setData('available_dates', data.available_dates.filter((item) => item !== event.target.value));
    }

    return (
        <DashboardLayout>

            <JobHeader viewModel={viewModel}/>

            <Content>
                <H1 className={"mt-8"}>Apply for this role</H1>

                {role.fields.digitals && (
                    <div>
                        <H2>Digitals</H2>
                        <P className={"mb-2"}>
                            { data.digitals.length >= 3
                                ? "Are your digitals up-to-date and relevant for this role?"
                                : "Upload at least 3 recent digitals"
                            }
                        </P>

                        <FileUploader
                            accept="image/*"
                            colsOnMobile={3}
                            cols={6}
                            files={data.digitals}
                            onAdd={(file) => setData(data => ({...data, digitals: [...data.digitals, file]}))}
                            onToggleUploading={(state) => setUploadingField('digitals', state)}
                            onUpdate={(digitals) => setData(data => ({...data, digitals}))}
                        />

                        <InputError message={errors.digitals}/>
                    </div>
                )}

                <div>
                    <H2>Relevant photos</H2>
                    <P className={`mb-2`}>Select and sort your most relevant photos that will get you hired for this
                        role.</P>

                    <FileUploader
                        accept={"image/*"}
                        files={data.photos}
                        onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                        onUpdate={(photos) => setData(data => ({...data, photos}))}
                        onToggleUploading={(state) => setUploadingField('photos', state)}
                    />
                    <InputError message={errors.photos}/>
                </div>

                {(role.fields.height || role.fields.chest || role.fields.waist || role.fields.hips || role.fields.shoe_size || role.fields.clothing_size_top) && (
                    <div>
                        <H2>Sizes</H2>
                        <P className={"mb-2"}>The following sizes are relevant for this job. Is everything still up to
                            date?</P>

                        <div className={"grid grid-cols-2 md:grid-cols-3 gap-4"}>
                            {role.fields.height && (
                                <InputGroupText
                                    title="Height (cm)"
                                    placeholder="cm"
                                    type={"number"}
                                    value={data.height}
                                    onChange={value => setData("height", parseInt(value))}
                                />
                            )}

                            {role.fields.chest && (
                                <InputGroupText
                                    title="Chest (cm)"
                                    type={"number"}
                                    value={data.chest}
                                    onChange={value => setData("chest", parseInt(value))}
                                />
                            )}

                            {role.fields.waist && (
                                <InputGroupText
                                    title="Waist (cm)"
                                    type={"number"}
                                    value={data.waist}
                                    onChange={value => setData("waist", parseInt(value))}
                                />
                            )}

                            {role.fields.hips && (
                                <InputGroupText
                                    title="Hips (cm)"
                                    type={"number"}
                                    value={data.hips}
                                    onChange={value => setData("hips", parseInt(value))}
                                />
                            )}

                            {role.fields.shoe_size && (
                                <InputGroupText
                                    title="Shoe size (eu)"
                                    type={"number"}
                                    value={data.shoe_size}
                                    onChange={value => setData("shoe_size", parseInt(value))}
                                />
                            )}

                            {role.fields.clothing_size_top && (
                                <InputGroupText
                                    title="Size (top, XS-XXL)"
                                    type={"text"}
                                    options={["", "XS", "S", "M", "L", "XL", "XXL"]}
                                    value={data.clothing_size_top || ""}
                                    onChange={value => setData("clothing_size_top", value)}
                                />
                            )}
                        </div>
                    </div>
                )}

                {role.casting_questions!==null &&
                    <InputGroupText
                        multiline
                        onChange={value => setData('casting_questions', value)}
                        title={role.casting_questions}
                    />
                }


                <div>
                    <H2>Availability</H2>
                    <P className={"mb-2"}>
                        Please confirm your availability for the following shoot dates. If not all are available we will
                        contact you to discuss.</P>
                        {shootDates.map((shootDate) => (
                            <label className={"flex flex-row text-teal items-center mb-2"} key={shootDate}>
                                <input type="checkbox" onChange={handleAvailability} name={"available"} value={shootDate}
                                       className={"mr-2"}/>
                                <span>{new Date(shootDate).toLocaleDateString()}</span>
                            </label>
                        ))
                    }
                    <InputError message={errors.available_dates}/>
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

                { !isDirty && hasErrors && <InputError message={"Please review the form errors before submitting again."} /> }


                <PrimaryButton onClick={submit} className={"mb-8"} disabled={isUploading || processing}>
                    {processing ? "Please wait..." : "Submit application"}
                </PrimaryButton>
            </Content>
        </DashboardLayout>
    );

}
