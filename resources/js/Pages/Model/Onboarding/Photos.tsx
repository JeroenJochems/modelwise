import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Step} from "@/Components/Onboarding/Step";
import PrimaryButton from "@/Components/PrimaryButton";
import {useForm} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";

type FormInterface = {
    photo: File|null
}

export type FileEventTarget = EventTarget & { files: FileList|null };

export default function Photos({modelPhotos}: {modelPhotos: string[] }) {

    const {data, setData, post, processing, errors, progress, reset} = useForm<FormInterface>({
        photo: null
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setData('photo', e.target.files[0]);

        post(route('onboarding.photos'));
    }

    const modelPhotoCount = modelPhotos.length

    return (
        <CleanLayout>
            <div className={"grid gap-4"}>

                <Step step={4} totalSteps={6} />

                <H1>Work experience</H1>
                <P>Upload a variety of 6 portfolio photos and add the brand name and year of the shoot.</P>
                <P>We use these photos to review your experience.</P>

                <form>
                    <label htmlFor="photo" className={"grid grid-cols-3 gap-4 cursor-pointer"}>
                        { modelPhotos.map((item, i) =>
                            <img key={i}  src={item} alt="" className={"object-cover w-full h-full rounded-md"}/>
                        )}

                        { [...Array(6 - modelPhotoCount)].map((item, i) =>
                            <div key={i} className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                {i}
                            </div>
                        )}
                    </label>

                    <input type="file" className="hidden" id="photo"
                           name="photo"
                           onChange={handleChange}/>
                </form>


                <PrimaryButton type="submit" className="w-full">
                    Continue
                </PrimaryButton>
            </div>
        </CleanLayout>
    )
}
