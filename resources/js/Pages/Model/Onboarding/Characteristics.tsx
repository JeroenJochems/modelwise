import { useState} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import { useForm, usePage} from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import {PageProps} from "@/types";
import PrimaryButton from "@/Components/PrimaryButton";
import {BaseFile, FileUploader} from "@/Components/FileUploader";
import {Ethnicity, EyeColor, HairColor} from "@/types/generated";

type ModelDataType = {
    gender?: string
    hair_color: string
    hair_color_other?: string
    eye_color: string
    height: string
    chest: string
    waist: string
    hips: string
    ethnicity: string
    ethnicity_other: string
    shoe_size: string
    tattoos: boolean
    piercings: boolean
    cup_size?: string
    tattoo_photos?: BaseFile[]
}

type Props = {
    modelData: ModelDataType
    hairColors: HairColor[],
    eyeColors: EyeColor[],
    ethnicities: Ethnicity[],
    tattooPhotos: BaseFile[],
    piercingPhotos: BaseFile[],
}

export default function Characteristics({modelData, tattooPhotos, piercingPhotos, hairColors, ethnicities, eyeColors}: Props) {

    const { ziggy } = usePage<PageProps>().props



    const isOnboarding = ziggy.location.includes("onboarding");
    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const [isUploading, setIsUploading] = useState<boolean>(false);

    const {data, setData, post, errors } = useForm({
        ...modelData,
        tattoo_photos: tattooPhotos ?? [],
        piercing_photos: piercingPhotos ?? [],
    });

    function submit() {
        setIsSubmitting(true);
        post(ziggy.location, {
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    }

    return (
        <CleanLayout header={
            <Header step={7} isOnboarding={isOnboarding}>
                <H1>Body characteristics</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/assets/8.jpeg?fm=auto&w=1200"]}>

            <div className="grid gap-4">

                <div>
                    <InputGroupText
                        title="Eye color"
                        value={data.hair_color ?? ""}
                        error={errors.hair_color}
                        options={hairColors}
                        onChange={value => setData('hair_color', value)}
                    />

                    { data.hair_color === "Other" && (
                        <TextInput id="hair_color_other" className="block mt-1 w-full"
                                   value={data.hair_color_other ?? ""}
                                   placeholder={"Specify other hair color"}
                                   onChange={e => setData('hair_color_other', e.target.value)} />
                    )}

                    {!! errors.hair_color && <InputError message={errors.hair_color} className="mt-2"/>}
                    {!! errors.hair_color_other && <InputError message={errors.hair_color_other} className="mt-2"/>}
                </div>

                <InputGroupText
                    title="Eye color"
                    value={data.eye_color ?? ""}
                    error={errors.eye_color}
                    options={eyeColors}
                    onChange={value => setData('eye_color', value)}
                />

                <div>
                    <InputGroupText
                        title={"Appearance / Ethnic features"}
                        name={"ethnicity"}
                        value={data.ethnicity ?? ""}
                        error={errors.ethnicity}
                        options={ethnicities}
                        onChange={value => setData('ethnicity', value)}
                    />

                    { data.ethnicity === "Other" && (
                        <TextInput id="ethnicity_other" className="block mt-1 w-full"
                                   value={data.ethnicity_other ?? ""}
                                   placeholder={"Please specify"}
                                   onChange={e => setData('ethnicity_other', e.target.value)} />
                    )}

                </div>
                <div className={"grid grid-cols-2 gap-4"}>

                    <InputGroupText
                        title="Body length (cm)"
                        value={data.height ?? ""}
                        error={errors.height}
                        type={"number"}
                        placeholder={"in cm"}
                        onChange={value => setData('height', value)}
                    />
                    <InputGroupText
                        title="Chest (cm)"
                        value={data.chest ?? ""}
                        error={errors.chest}
                        type={"number"}
                        placeholder={"in cm"}
                        onChange={value => setData('chest', value)}
                    />
                    <InputGroupText
                        title="Waist (cm)"
                        value={data.waist ?? ""}
                        error={errors.waist}
                        type={"number"}
                        placeholder={"in cm"}
                        onChange={value => setData('waist', value)}
                    />
                    <InputGroupText
                        title="Hips (cm)"
                        value={data.hips ?? ""}
                        error={errors.hips}
                        type={"number"}
                        placeholder={"in cm"}
                        onChange={value => setData('hips', value)}
                    />
                    <InputGroupText
                        title="Shoe size (EU)"
                        value={data.shoe_size ?? ""}
                        error={errors.shoe_size}
                        type={"number"}
                        placeholder={"in cm"}
                        onChange={value => setData('shoe_size', value)}
                    />
                    { modelData.gender!=="Male" && (
                        <InputGroupText
                            title="Cup size (EU)"
                            value={data.cup_size ?? ""}
                            error={errors.cup_size}
                            onChange={value => setData('cup_size', value)}
                        />
                    )}
                </div>

                <div>
                    <InputGroupText
                        title="Tattoos?"
                        value={data.tattoos ? "Yes" : "No"}
                        error={errors.tattoos}
                        options={["No", "Yes"]}
                        onChange={value => setData('tattoos', value==="Yes")}
                    />

                    { data.tattoos && (
                        <div className={"mt-2 grid gap-2"}>
                            <P>Tattoo reference photos</P>

                            <FileUploader
                                accept={"image/*"}
                                files={data.tattoo_photos}
                                onUpdate={photos => setData('tattoo_photos', photos)}
                                onAdd={(photo) => setData(data => ({...data, tattoo_photos: [...data.tattoo_photos, photo]}))}
                                onToggleUploading={setIsUploading}
                            />
                        </div>
                    )}
                </div>

                <InputGroupText
                    title="Piercings?"
                    value={data.piercings ? "Yes" : "No"}
                    error={errors.piercings}
                    options={["No", "Yes"]}
                    onChange={value => setData('piercings', value==="Yes")}
                />

                { data.piercings && (
                    <div className={"mt-2 grid gap-2"}>
                        <P>Piercing reference photos</P>

                        <FileUploader
                            accept={"image/*"}
                            files={data.piercing_photos}
                            onUpdate={photos => setData('piercing_photos', photos)}
                            onAdd={(photo) => setData(data => ({...data, piercing_photos: [...data.piercing_photos, photo]}))}
                            onToggleUploading={setIsUploading}
                        />
                    </div>
                )}


                <PrimaryButton onClick={submit} disabled={ isUploading || isSubmitting }>
                    { isSubmitting ? "Please wait..." : "Continue" }
                </PrimaryButton>
            </div>
        </CleanLayout>
    )
}
