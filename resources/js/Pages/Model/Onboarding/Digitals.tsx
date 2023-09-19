import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Header} from "@/Components/Onboarding/Header";
import { useForm, usePage} from "@inertiajs/react";
import {PageProps} from "@/types";
import {useState} from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import {BaseFile, FileUploader} from "@/Components/FileUploader";


export default function Photos({modelDigitals}: {modelDigitals: BaseFile[] }) {
    const { ziggy } = usePage<PageProps>().props;
    const isOnboarding = ziggy.location.includes("onboarding")

    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { post, data, setData } = useForm({
        photos: modelDigitals
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
            <Header step={5} isOnboarding={isOnboarding}>
                <H1>Digitals / polaroids</H1>
            </Header>
        }  photos={["https://modelwise.imgix.net/assets/9.jpeg?w=1200&fm=auto"]}>
            <div className="grid gap-4">
                <FileUploader
                    cols={3}
                    files={data.photos}
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
