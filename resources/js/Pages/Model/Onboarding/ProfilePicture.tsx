import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import { useForm, usePage} from "@inertiajs/react";
import {FormEvent, FormEventHandler } from "react";
import {PageProps} from "@/types";
import PrimaryButton from "@/Components/PrimaryButton";
import {InlinePhotoUploader, Photo} from "@/Components/InlinePhotoUploader";

type ModelDataType = {
    profile_picture: Photo|null
}

export default function ProfilePicture(props: ModelDataType) {
    const { profile_picture } = props;
    const { location } = usePage<PageProps>().props.ziggy

    const { data, setData, post } = useForm<ModelDataType>({
        profile_picture: profile_picture
    });

    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(location);
    };

    const isOnboarding = location.includes("onboarding");

    return (
        <CleanLayout header={
            <Header step={3} isOnboarding={isOnboarding}>
                <H1>Profile picture</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/photos/f52a5068-0423-4eed-9507-c535ee69a347"]}>

            <P>Upload a colour headshot in portrait format. This will be your primary portfolio photo.</P>

            <form className={"grid gap-4"}>
                <div className={"w-48 mx-auto"}>
                    <InlinePhotoUploader
                        cols={1}
                        colsOnMobile={1}
                        max={1}
                        slots={1}
                        photos={data.profile_picture ? [data.profile_picture] : []}
                        onAdd={(photo) => setData('profile_picture', photo)}
                        onUpdate={(photos) => setData('profile_picture', photos[0] || null)}
                    />
                </div>

                <PrimaryButton onClick={submit}>
                    { isOnboarding ? "Continue" : "Save" }
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
