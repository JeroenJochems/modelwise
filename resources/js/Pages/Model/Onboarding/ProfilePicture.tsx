import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Step} from "@/Components/Onboarding/Step";
import PrimaryButton from "@/Components/PrimaryButton";
import {router, useForm} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";
import Vapor from "laravel-vapor";

export type FileEventTarget = EventTarget & { files: FileList|null };

type FormInterface = {
    profile_picture: File|null
}

type Data = {
    profile_picture: string|null
}



export default function ProfilePicture({ profile_picture }: Data) {

    const [file, setFile] = useState(profile_picture ?? Vapor.asset('img/headshot-placeholder.png'));

    const {data, setData, post, processing, errors, progress, reset} = useForm<FormInterface>({
        profile_picture: null,
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setFile(URL.createObjectURL(e.target.files[0]));

        Vapor.store(e.target.files[0]).then(response => {
            setData('profile_picture', response.key)
        })
    }

    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        if (profile_picture && !data.profile_picture) {
            return router.visit(route('onboarding.photos'));
        }

        post(route('onboarding.profile-picture'));
    };

    return (
        <CleanLayout>
            <div className={"grid gap-4"}>

                <Step step={3} totalSteps={6} />

                <H1>Profile picture</H1>
                <P>Upload a colour headshot in portrait format. This will be your primary portfolio photo.</P>

                <form onSubmit={submit} className={"grid gap-4"}>
                    <input type="file" className="hidden" id={"profile_picture"}
                           name={"profile_picture"}
                           onChange={handleChange}/>


                    <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                        <img src={file} alt="Profile picture" className={"mx-auto"} style={{width: 200}}/>
                    </label>

                    {progress && (
                        <progress className={"bg-green"} value={progress.percentage} max="100">
                            {progress.percentage}%
                        </progress>
                    )}

                    <PrimaryButton type="submit" className="w-full">
                        Continue
                    </PrimaryButton>
                </form>
            </div>
        </CleanLayout>
    )
}
