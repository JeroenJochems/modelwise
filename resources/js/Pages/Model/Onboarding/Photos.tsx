import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Step} from "@/Components/Onboarding/Step";
import PrimaryButton from "@/Components/PrimaryButton";
import {useForm} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";
import {InertiaFormProps} from "@inertiajs/react/types";

export type FileEventTarget = EventTarget & { files: FileList|null };

interface FormInterface {
    profile_picture: string
}

export default function Photos() {

    const [file, setFile] = useState('/img/headshot-placeholder.png');

    const {data, setData, post, processing, errors, progress, reset}: InertiaFormProps<FormInterface> = useForm({
        profile_picture: null,
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setFile(URL.createObjectURL(e.target.files[0]));
        setData('profile_picture', e.target.files[0])
    }


    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('onboarding.profile-picture'));
    };

    return (
        <CleanLayout>
            <div className={"grid gap-4"}>

                <Step step={4} totalSteps={6} />

                <H1>Work experience</H1>
                <P>Upload a variety of 6 portfolio photos and add the brand name and year of the shoot.</P>
                <P>We use these photos to review your experience.</P>

                <form onSubmit={submit} className={"grid gap-4"}>

                    <div className={"grid grid-cols-3 gap-4"}>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>

                        <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                            <input type="file" className="hidden" id={"profile_picture"}
                                   name={"profile_picture"}
                                   onChange={handleChange}/>

                            <div className={"flex text-gray-500 text-2xl justify-center items-center aspect-[1/1] bg-gray-200 border border-gray-500 rounded-md"}>
                                +
                            </div>
                        </label>


                    </div>


                    <PrimaryButton type="submit" className="w-full">
                        Continue
                    </PrimaryButton>
                </form>
            </div>
        </CleanLayout>
    )
}
