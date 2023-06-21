import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Step} from "@/Components/Onboarding/Step";
import PrimaryButton from "@/Components/PrimaryButton";
import {router, useForm} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";
import Vapor from "laravel-vapor";
import {transcode} from "buffer";

export type FileEventTarget = EventTarget & { files: FileList|null };

export default function Photos({modelPhotos}: {modelPhotos: string[] }) {

    const [isLoading, setIsLoading] = useState(false);
    const {transform, post} = useForm({
        path: ''
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setIsLoading(true);

        Vapor.store(e.target.files[0])
            .then(response => {
                router.post(route('onboarding.photos'), { path:  response.key })
                setIsLoading(false);
            })
    }

    const modelPhotoCount = modelPhotos.length

    return (
        <CleanLayout>
            <div className={`grid gap-4 ${isLoading ? "cursor-wait" : ""}`}>


                <Step step={4} totalSteps={6} />

                <H1>Work experience</H1>
                <P>Upload a variety of 6 portfolio photos. We use these photos to review your experience.</P>

                <form>
                    <label htmlFor="photo" className={"grid grid-cols-3 gap-4 cursor-pointer"}>
                        { modelPhotos.map((item, i) =>
                            <img key={i}  src={item} alt="" className={"object-cover w-full h-full rounded-md"}/>
                        )}



                        { [...Array(6 - modelPhotoCount)].map((item, i) =>
                            <div key={i} className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                {i+modelPhotoCount+1}
                            </div>
                        )}
                    </label>

                    <input type="file" className="hidden" id="photo"
                           name="photo"
                           onChange={handleChange}/>
                </form>


                {modelPhotoCount >= 3 &&
                    <PrimaryButton onClick={() => router.visit(route("onboarding.socials"))} type="submit">
                        Continue
                    </PrimaryButton>
                }
            </div>
        </CleanLayout>
    )
}
