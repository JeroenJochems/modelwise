import {FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {Header} from "@/Components/Onboarding/Header";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import {useForm, usePage} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {PageProps} from "@/types";
import {ModelData} from "@/types/generated";


type Props = {
    modelData: ModelData
}

export default function Socials({modelData}: Props) {

    const {ziggy} = usePage<PageProps>().props;
    const isOnboarding = ziggy.location.includes("onboarding");

    const {data, setData, post, errors} = useForm({
        instagram: modelData.instagram ?? "",
        tiktok: modelData.tiktok ?? "",
        website: modelData.website ?? "http://",
        showreel_link: modelData.showreel_link ?? "http://",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(ziggy.location);
    };

    return (
        <CleanLayout  photos={["https://modelwise.imgix.net/assets/6.2.jpeg?w=1200&fm=auto"]} header={
            <Header step={6} isOnboarding={isOnboarding}>
                <H1>Socials</H1>
            </Header>
        }>
            <div className="grid grid-cols-1 gap-4 mb-4">

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
                    title="TikTok"
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

                <InputGroupText
                    title="Showreel"
                    value={data.showreel_link}
                    error={errors.showreel_link}
                    autoComplete="website"
                    onChange={value => setData('showreel_link', value)}
                />

                <Submit>
                    Continue
                </Submit>
            </form>
        </CleanLayout>
    )
}
