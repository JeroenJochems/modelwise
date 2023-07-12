import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Header} from "@/Components/Onboarding/Header";
import { useForm, usePage} from "@inertiajs/react";
import {Submit} from "@/Components/Forms/Submit";
import {InlinePhotoUploader, Photo} from "@/Components/InlinePhotoUploader";
import {PageProps} from "@/types";


export default function Photos({modelDigitals}: {modelDigitals: Photo[] }) {

    const isOnboarding = usePage<PageProps>().props.ziggy.location.includes("onboarding")

    const { post, data, setData } = useForm({
        photos: modelDigitals
    });

    function submit() {
        post(route("account.digitals.store"))
    }

    return (
        <CleanLayout>
            <div className="grid gap-4">

                <Header step={5} isOnboarding={isOnboarding} />

                <H1>Digitals (optional)</H1>

                <InlinePhotoUploader
                    cols={3}
                    photos={data.photos}
                    onAddPhoto={(id, tmpFile, localUrl) => (
                        setData(data => ({...data, photos: [...data.photos, { id, tmpFile,filtered: false, path: localUrl}]}))
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

                <Submit onClick={submit}>
                    Continue
                </Submit>
            </div>
        </CleanLayout>
    )
}
