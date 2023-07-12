import {FormEventHandler, useState} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import {Link, router, useForm, usePage} from '@inertiajs/react';
import {Submit} from "@/Components/Forms/Submit";
import HairColor = Domain.Models.Enums.HairColor;
import EyeColor = Domain.Models.Enums.EyeColor;
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {InlinePhotoUploader, Photo} from "@/Components/InlinePhotoUploader";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import {PageProps} from "@/types";

type ModelDataType = {
    gender?: string
    hair_color: string
    hair_color_other?: string
    eye_color: string
    height: string
    chest: string
    waist: string
    hips: string
    shoe_size: string
    tattoos: boolean
    piercings: boolean
    cup_size?: string
    tattoo_photos?: Photo[]
}


type Props = {
    modelData: ModelDataType
    hairColors: HairColor[],
    eyeColors: EyeColor[],
    tattooPhotos: Photo[],
}

export default function Characteristics({modelData, tattooPhotos, hairColors, eyeColors}: Props) {

    const { ziggy } = usePage<PageProps>().props

    const isOnboarding = ziggy.location.includes("onboarding");

    const {data, setData, post, errors } = useForm({
        ...modelData,
        tattoo_photos: tattooPhotos ?? []
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('account.characteristics.store'));
    };

    return (
        <CleanLayout>

            <Header step={7} isOnboarding={isOnboarding} />

            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <H1>Body characteristics</H1>
            </div>

            <form onSubmit={submit} className="grid gap-4">

                <div>
                    <InputLabel htmlFor="hair_color" value="Hair color" />

                    <select id="hair_color"
                            className="border-gray-300 focus:border-green focus:ring-green rounded-sm shadow-sm block mt-1 w-full"
                            value={data.hair_color ?? ""}
                            onChange={e => setData('hair_color', e.target.value) }>
                            {["", ...hairColors].map((option: any) =>
                                <option key={option} value={option}>{option}</option>
                            )}

                    </select>

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
                    options={["", ...eyeColors]}
                    onChange={value => setData('eye_color', value)}
                />

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

                            <InlinePhotoUploader
                                photos={data.tattoo_photos}
                                onAddPhoto={(id, tmpFile, localUrl) => (
                                    setData(data => ({...data, tattoo_photos: [...data.tattoo_photos, { id, tmpFile,filtered: false, path: localUrl}]}))
                                )}
                                onUpdateSorting={(photos) => setData(data => (
                                    {...data, tattoo_photos: photos}
                                ))}
                                onDeletePhoto={(id) => setData(data => (
                                    {
                                        ...data,
                                        tattoo_photos: data.tattoo_photos.map(photo => photo.id === id ? {...photo, deleted: true} : photo)
                                    }
                                ))}
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

                <Submit>
                    Continue
                </Submit>
            </form>
        </CleanLayout>
    )
}
