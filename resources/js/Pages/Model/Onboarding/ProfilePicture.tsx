import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import PrimaryButton from "@/Components/PrimaryButton";
import {router, useForm, usePage} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";
import Vapor from "laravel-vapor";
import {Submit} from "@/Components/Forms/Submit";
import {PageProps} from "@/types";

export type FileEventTarget = EventTarget & { files: FileList|null };

type FormInterface = {
    profile_picture: File|null
}

type ModelDataType = {
    profile_picture: string|null
}

type Props = {
    modelData: ModelDataType
}


export default function ProfilePicture({ modelData }: Props) {

    const { ziggy } = usePage<PageProps>().props

    const {profile_picture} = modelData;

    const [file, setFile] = useState(profile_picture);
    const [hasEdited, setHasEdited] = useState(false);

    const {data, setData, post, processing, errors, progress, reset} = useForm<FormInterface>({
        profile_picture: null,
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setFile(URL.createObjectURL(e.target.files[0]));
        setHasEdited(true);

        Vapor.store(e.target.files[0]).then(response => {
            setData('profile_picture', response.key)
        })
    }

    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('account.profile-picture.store'));
    };

    const isOnboarding = ziggy.location.includes("onboarding");

    return (
        <CleanLayout>
            <div className={"grid gap-4"}>

                <Header step={3} isOnboarding={isOnboarding} />

                <H1>Profile picture</H1>
                <P>Upload a colour headshot in portrait format. This will be your primary portfolio photo.</P>

                <form onSubmit={submit} className={"grid gap-4"}>
                    <input type="file" className="hidden" id={"profile_picture"}
                           name={"profile_picture"}
                           onChange={handleChange}/>


                    <label htmlFor={"profile_picture"} className={"cursor-pointer"}>
                        <img src={file ?? Vapor.asset('img/headshot-placeholder.png')} alt="Profile picture" className={"mx-auto"} style={{width: 200}}/>
                        {!hasEdited && <div className={"text-center"}>edit</div> }
                    </label>

                    {progress && (
                        <progress className={"bg-green"} value={progress.percentage} max="100">
                            {progress.percentage}%
                        </progress>
                    )}

                    <Submit>
                        { isOnboarding ? "Continue" : "Save" }
                    </Submit>
                </form>
            </div>
        </CleanLayout>
    )
}
