import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Header} from "@/Components/Onboarding/Header";
import { useForm, usePage} from "@inertiajs/react";
import {InlinePhotoUploader, Photo} from "@/Components/InlinePhotoUploader";
import {PageProps} from "@/types";
import {useState} from "react";
import PrimaryButton from "@/Components/PrimaryButton";


export default function Photos({modelDigitals}: {modelDigitals: Photo[] }) {

    const isOnboarding = usePage<PageProps>().props.ziggy.location.includes("onboarding")

    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { post, data, setData } = useForm({
        photos: modelDigitals
    });


    function submit() {
        setIsSubmitting(true);
        post(route('account.digitals.store'), {
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    }

    return (
        <CleanLayout photo={"photos/d3f0b9b3-c079-41bc-b403-5ddc78d2dddd"}>
            <div className="grid gap-4">

                <Header step={5} isOnboarding={isOnboarding} />

                <H1>Digitals (optional)</H1>

                <InlinePhotoUploader
                    cols={3}
                    photos={data.photos}
                    onToggleUploading={setIsUploading}
                    onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                    onUpdate={(photos) => setData(data => ({...data, photos}))}
                />

                <PrimaryButton onClick={submit} disabled={isSubmitting || isUploading}>
                    { isSubmitting ? 'Saving...' : 'Continue' }
                </PrimaryButton>
            </div>
        </CleanLayout>
    )
}
