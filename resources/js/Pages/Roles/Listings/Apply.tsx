import {P} from "@/Components/Typography/p";
import {ChangeEvent, useState} from "react";
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
import {FileUploader} from "@/Components/FileUploader";
import {ApplyData, ModelMeViewModel, ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel;
    meViewModel: ModelMeViewModel;
}

type Form = { role_id: number | string } & ApplyData

export default function Apply({viewModel, meViewModel}: Props) {

    const {errors} = usePage().props

    const [isUploading, setIsUploading] = useState(false);

    const {role, shootDates} = viewModel;
    const me = meViewModel.me;

    const askForSizes = role.fields.height || role.fields.chest || role.fields.waist || role.fields.hips || role.fields.shoe_size || role.fields.clothing_size_top;

    const {post, data, setData, processing, hasErrors, clearErrors } = useForm<Form>({
        role_id: role.id,
        digitals: [],
        photos: [],
        height: me.height,
        casting_questions: "",
        chest: me.chest,
        waist: me.waist,
        hips: me.hips,
        shoe_size: me.shoe_size,
        clothing_size_top: me.clothing_size_top,
        cover_letter: "",
        available_dates: [],
        brand_conflicted: ""
    });

    function submit() {
        clearErrors();
        post(route('applications.store', viewModel.role.id));
    }

    function handleAvailability(event: ChangeEvent<HTMLInputElement>) {
        event.target.checked
            ? setData('available_dates', [...data.available_dates, event.target.value])
            : setData('available_dates', data.available_dates.filter((item) => item !== event.target.value));
    }

    return (
        <DashboardLayout>
            <Content>
                <div>
                    <H2 className={"text-gray-600"}>{viewModel.role.job.title}</H2>
                    <H1>Apply for: {viewModel.role.name}</H1>
                </div>

                {role.fields.digitals && (
                    <div>
                        <H2>Digitals / Polaroids</H2>
                        <P className={"mb-2"}>
                            {data.digitals.length >= 3
                                ? "Are your polaroids up-to-date?"
                                : "Upload at least 3 recent polaroids"
                            }
                        </P>

                        <FileUploader
                            accept="image/*"
                            slots={4}
                            colsOnMobile={4}
                            cols={4}
                            opaqueAfter={4}
                            files={data.digitals}
                            onAdd={(file) => setData(data => ({...data, digitals: [...data.digitals, file]}))}
                            onToggleUploading={setIsUploading}
                            onUpdate={(digitals) => setData(data => ({...data, digitals}))}
                        />

                        <InputError message={errors.digitals}/>
                    </div>
                )}

                <div>
                    <H2>Portfolio photos</H2>
                    <P className={`mb-2`}>The first 8 photos will be shown with your application.</P>

                    <FileUploader
                        name={"photos"}
                        accept={"image/*"}
                        files={data.photos}
                        slots={8}
                        opaqueAfter={8}
                        onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                        onUpdate={(photos) => setData(data => ({...data, photos}))}
                        onToggleUploading={setIsUploading}
                        cols={8}
                        colsOnMobile={4}
                    />
                    <InputError message={errors.photos}/>
                </div>

                {askForSizes && (
                    <div>
                        <H2 className={"pb-2"}>Are your sizes up to date?</H2>

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

                {role.casting_questions !== null &&
                    <div className={'my-4'}>
                        <H2>{role.casting_questions.split("\n").length > 1 ? "Please answer these questions" : "Please answer this question"}</H2>
                        <InputGroupText
                            multiline
                            onChange={value => setData('casting_questions', value)}
                            title={role.casting_questions}
                        />
                    </div>
                }


                <div className={"grid gap-4"}>
                    <div>
                        <H2>Availability</H2>
                        <P className={"mb-2"}>
                            Please confirm your availability for the following shoot dates. If not all are available we will
                            contact you to discuss.</P>
                    </div>

                    {shootDates.map((shootDate) => (
                        <label className={"flex flex-row text-teal items-center mb-2"} key={shootDate}>
                            <input type="checkbox" onChange={handleAvailability} name={"available"} value={shootDate}
                                   className={"mr-2"}/>
                            <span>{new Date(shootDate).toLocaleDateString()}</span>
                        </label>
                    ))
                    }
                    <InputError message={errors.available_dates}/>

                    <InputGroupText
                        title="Have you worked with a competing brand in the last 3 years?"
                        multiline={true}
                        onChange={value => setData('brand_conflicted', value)}
                    />

                    <InputGroupText
                        title="Is there anything you'd like to add to your application?"
                        multiline={true}
                        onChange={value => setData('cover_letter', value)}
                    />
                </div>


                { hasErrors && <InputError message="Please review the errors in the form above."/> }

                <PrimaryButton onClick={submit} className={"mb-8"} disabled={isUploading || processing}>
                    {processing ? "Please wait..." : "Submit application"}
                </PrimaryButton>
            </Content>
        </DashboardLayout>
    );

}
