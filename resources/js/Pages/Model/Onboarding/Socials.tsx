import {ChangeEvent, FormEvent, FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {Step} from "@/Components/Onboarding/Step";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import PrimaryButton from "@/Components/PrimaryButton";
import { useForm } from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";

type ModelDataType = {
    instagram: string
    tiktok: string
    website: string
}

type Props = {
    modelData: ModelDataType
}

export default function Socials({modelData}: Props) {

    const {data, setData, post, errors } = useForm({
        instagram: modelData.instagram ?? "",
        tiktok: modelData.tiktok ?? "",
        website: modelData.website ?? "http://",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('onboarding.socials'));
    };

    return (
        <CleanLayout>
            <Step step={6} totalSteps={6} backLink={route("onboarding.digitals")} />

            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <H1>Socials</H1>
                <P>Sharing your social accounts helps showcasing your work, recognition and personality.</P>
                <P>Include at least your Instagram or Tiktok account.</P>
            </div>

            <form onSubmit={submit} className="grid gap-4">

                <InputGroupText
                    title="Instagram"
                    value={data.instagram}
                    error={errors.instagram}
                    autoComplete="instagram"
                    onChange={(value: string) => setData('instagram', value)}
                />

                <InputGroupText
                    title="Tik-tok"
                    value={data.tiktok}
                    error={errors.tiktok}
                    autoComplete="tiktok"
                    onChange={value => setData('tiktok', value)}
                />

                <InputGroupText
                    title="Website"
                    value={data.website}
                    error={errors.website}
                    autoComplete="website"
                    onChange={value => setData('website', value)}
                />


                <Submit>
                    Continue
                </Submit>
            </form>
        </CleanLayout>
    )
}