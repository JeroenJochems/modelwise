import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import { useForm, usePage} from "@inertiajs/react";
import {FormEvent, FormEventHandler, useState} from "react";
import Vapor from "laravel-vapor";
import {Submit} from "@/Components/Forms/Submit";
import {PageProps} from "@/types";
import {UserProfilePhoto} from "@/Components/Atoms/UserProfilePhoto";
import PrimaryButton from "@/Components/PrimaryButton";

export type FileEventTarget = EventTarget & { files: FileList|null };

type ModelDataType = {
    profile_picture: string|null
}

type Props = {
    modelData: ModelDataType
}

type UploadProgress = {
    id: string
    progress: number
}

export default function ProfilePicture({ modelData }: Props) {

    const { ziggy, cdn_url } = usePage<PageProps>().props
    const [uploadProgress, setUploadProgress] = useState<number>(0);

    const [hasEdited, setHasEdited] = useState(false);

    const { data, setData, post } = useForm<ModelDataType>({
        profile_picture: null
    });

    function handleChange(e: FormEvent<HTMLInputElement> & { target: FileEventTarget }) {

        if (e.target.files===null) return;

        setHasEdited(true);

        const file = e.target.files[0]

        Vapor.store(file, {
            // @ts-ignore
            signedStorageUrl: '/photos/signed-url',
            progress: progress => {
                setUploadProgress(Math.round(progress * 100));
            }
        }).then(response => {
            setData('profile_picture', response.key)
        })
    }

    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(ziggy.location);
    };

    const isOnboarding = ziggy.location.includes("onboarding");

    console.log(modelData);

    return (
        <CleanLayout header={
            <Header step={3} isOnboarding={isOnboarding}>
                <H1>Profile picture</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/photos/f52a5068-0423-4eed-9507-c535ee69a347"]}>
            <P>Upload a colour headshot in portrait format. This will be your primary portfolio photo.</P>

            <form className={"grid gap-4"}>
                <input type="file" className="hidden" id={"profile_picture"}
                       name={"profile_picture"}
                       onChange={handleChange}/>


                <label htmlFor={"profile_picture"} className={"grid gap-4 items-center flex-col cursor-pointer"}>

                    { !!modelData.profile_picture ? <img src={modelData.profile_picture + "?w=400&h=400&fit=crop&crop=faces"} alt="Profile picture" className={"mx-auto"} style={{width: 200}}/>
                        : <div className={"mx-auto"}><UserProfilePhoto /></div> }
                    <span
                        className={"mx-auto items-center py-1 px-4 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"}>
                        Upload headshot
                    </span>
                </label>

                { !!uploadProgress && (
                    <div className={"h-2 mt-2"}>
                        { uploadProgress && uploadProgress < 100 ? (
                            <div className="w-full bg-gray-100 h-2 rounded-full">
                                <div style={{ width: uploadProgress + '%'}}  className="bg-green h-2 rounded-full"></div>
                            </div>
                        ) : (
                            <div className={"w-full h-2"}></div>
                        ) }
                    </div>
                )}

                <PrimaryButton onClick={submit} disabled={uploadProgress>0 && uploadProgress<100}>
                    { isOnboarding ? "Continue" : "Save" }
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
