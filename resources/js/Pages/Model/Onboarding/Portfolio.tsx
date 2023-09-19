import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import {router, useForm, usePage} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import {PageProps} from "@/types";
import {useState} from "react";
import {BaseFile, FileUploader} from "@/Components/FileUploader";


export type FileEventTarget = EventTarget & { files: FileList|null };

export default function Portfolio({modelPhotos}: {modelPhotos: BaseFile[] }) {

    const { props } = usePage<PageProps>()
    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

    const isOnboarding = props.ziggy.location.includes("onboarding");

    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { post, data, progress, setData } = useForm({
        photos: modelPhotos
    });

    function submit() {
        setIsSubmitting(true);
        post(props.ziggy.location, {
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    }

    return (
        <CleanLayout header={
            <Header step={4} isOnboarding={isOnboarding}>
                <H1>Your best photos</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/assets/11.jpeg?w=1200&fm=auto"]}>

                <P>Upload at least 6 of your best photos. You can upload as many as you want and always update this later.</P>

                <FileUploader
                    cols={3}
                    accept={"image/*"}
                    files={data.photos}
                    onToggleUploading={setIsUploading}
                    onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                    onUpdate={(photos) => { setData(data => ({...data, photos})) }}
                />

                <PrimaryButton onClick={submit} disabled={isSubmitting || isUploading || ( isOnboarding && data.photos.length < 3)}>
                    { isSubmitting ? `Please wait...` : isOnboarding ? 'Continue' : 'Save' }
                </PrimaryButton>
        </CleanLayout>
    )
}
