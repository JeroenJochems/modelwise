import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import {router, useForm, usePage} from "@inertiajs/react";
import {InlinePhotoUploader, Photo} from "@/Components/InlinePhotoUploader";
import PrimaryButton from "@/Components/PrimaryButton";
import {PageProps} from "@/types";
import {useState} from "react";


export type FileEventTarget = EventTarget & { files: FileList|null };

export default function Portfolio({modelPhotos}: {modelPhotos: Photo[] }) {

    const { props } = usePage<PageProps>()
    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

    const isOnboarding = props.ziggy.location.includes("onboarding");

    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { post, data, progress, setData } = useForm({
        photos: modelPhotos
    });

    function submit() {
        setIsSubmitting(true);
        post(route('account.portfolio.store'), {
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    }

    return (
        <CleanLayout>
            <div className={`grid gap-4`}>

                <Header step={4} isOnboarding={isOnboarding} />

                <H1>Work experience</H1>
                <P>Upload a variety of 6 portfolio photos. We use these photos to review your experience.</P>

                <div>
                    <InlinePhotoUploader
                        cols={3}
                        photos={data.photos}
                        onStart={() => setIsUploading(true)}
                        onFinished={() => setIsUploading(false)}
                        onAddPhoto={(id, tmpFile, localUrl) => (
                            setData(data => ({...data, photos: [...data.photos, { id, tmpFile, filtered: false, path: localUrl}]}))
                        )}
                        onUpdateSorting={(photos) => setData(data => (
                            {...data, photos: photos}
                        ))}
                        onDeletePhoto={(id) => setData(data => (
                            {
                                ...data,
                                photos: data.photos.map(photo => photo.id === id ? {...photo, deleted: true} : photo)
                            }
                        ))}
                    />
                </div>

                <PrimaryButton onClick={submit} disabled={isSubmitting || isUploading || ( isOnboarding && data.photos.length < 3)}>
                    { isSubmitting ? `Please wait...` : isOnboarding ? 'Continue' : 'Save' }
                </PrimaryButton>
            </div>
        </CleanLayout>
    )
}
