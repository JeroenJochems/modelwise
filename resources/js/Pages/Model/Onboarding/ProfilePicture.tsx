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
import SecondaryButton from "@/Components/SecondaryButton";
import SmallButton from "@/Components/SmallButton";

export type FileEventTarget = EventTarget & { files: FileList|null };

type ModelDataType = {
    profile_picture: string|null
}

type Props = {
    modelData: ModelDataType
}


export default function ProfilePicture({ modelData }: Props) {

    const { ziggy, cdn_url } = usePage<PageProps>().props

    const [hasEdited, setHasEdited] = useState(false);

    const { data, setData, post, progress } = useForm<ModelDataType>({
        profile_picture: null
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

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

    const path = data.profile_picture
        ? cdn_url + data.profile_picture
        : modelData.profile_picture
            ? modelData.profile_picture
            : Vapor.asset('img/headshot-placeholder.png')

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


                    <label htmlFor={"profile_picture"} className={"grid gap-4 items-center flex-col cursor-pointer"}>
                        <img src={path} alt="Profile picture" className={"mx-auto"} style={{width: 200}}/>
                        <span
                            className={"mx-auto items-center py-1 px-4 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"}>
                            Upload a photo
                        </span>
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
