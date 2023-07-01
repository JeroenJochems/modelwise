import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Step} from "@/Components/Onboarding/Step";
import { router } from "@inertiajs/react";
import {Submit} from "@/Components/Forms/Submit";
import {PhotoUploader} from "@/Components/PhotoUploader";

type Digital = {
    id: number
    path: string
}

export default function Photos({modelDigitals}: {modelDigitals: Digital[] }) {


    return (
        <CleanLayout>
            <div className="grid gap-4">

                <Step step={5} totalSteps={6} backLink={route("onboarding.photos")} />

                <H1>Digitals (optional)</H1>

                <PhotoUploader folder={"Digitals"} photos={modelDigitals} />

                <Submit onClick={() => router.visit(route("onboarding.socials"))}>
                    Continue
                </Submit>
            </div>
        </CleanLayout>
    )
}
