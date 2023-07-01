import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Step} from "@/Components/Onboarding/Step";
import {router } from "@inertiajs/react";
import {Submit} from "@/Components/Forms/Submit";
import {PhotoUploader} from "@/Components/PhotoUploader";

export type FileEventTarget = EventTarget & { files: FileList|null };

type ModelPhoto = {
    id: string | number
    chosen?: boolean;
    path?: string
    filtered?: boolean;
}

export default function Photos({modelPhotos}: {modelPhotos: ModelPhoto[] }) {

    return (
        <CleanLayout>
            <div className={`grid gap-4`}>

                <Step step={4} totalSteps={6} backLink={route("onboarding.profile-picture")} />

                <H1>Work experience</H1>
                <P>Upload a variety of 6 portfolio photos. We use these photos to review your experience.</P>


                <PhotoUploader folder={"Work experience"} photos={modelPhotos} />


                {modelPhotos.length >= 3 &&
                    <Submit onClick={() => router.visit(route("onboarding.digitals"))}>
                        Continue
                    </Submit>
                }
            </div>
        </CleanLayout>
    )
}
