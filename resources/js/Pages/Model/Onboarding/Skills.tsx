import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";
import {Header} from "@/Components/Onboarding/Header";
import {useForm, usePage} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import {PageProps} from "@/types";
import {useState} from "react";
import {BaseFile, FileUploader} from "@/Components/FileUploader";
import {TagCloud} from "@/Components/TagCloud";
import {SkillsViewModel} from "@/types/generated";

type Props = {
    vm: SkillsViewModel,
    modelPhotos: BaseFile[]
}

export type FileEventTarget = EventTarget & { files: FileList|null };

type FormType = {
    skills: string[],
    photos: BaseFile[]
}

export default function Portfolio({vm, modelPhotos}: Props) {

    const { props } = usePage<PageProps>()
    const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

    const isOnboarding = props.ziggy.location.includes("onboarding");

    const [isUploading, setIsUploading] = useState<boolean>(false);

    const { post, data, setData } = useForm<FormType>({
        skills: vm.selectedSkills,
        photos: modelPhotos
    });

    function submit() {
        setIsSubmitting(true);
        post(props.ziggy.location, {
            onFinish: () => {
                setIsSubmitting(false);
            }
        });
    }

    function toggleActivity(slug: string) {
        if (data.skills.includes(slug)) {
            setData("skills", [...data.skills.filter(item => item !== slug)]);
        } else {
            setData("skills", [...data.skills, slug]);
        }
    }

    return (
        <CleanLayout header={
            <Header step={4} isOnboarding={isOnboarding}>
                <H1>Got skills?</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/assets/3.png?w=1200&fm=auto"]}>

                <P>Which relevant skills do you want to receive jobs for?</P>

                <TagCloud tags={vm.allSkills}
                      includeOther={false}
                      selected={data.skills}
                      onToggle={toggleActivity}/>

                <P>Do you have photos of yourself performing relevant skills? Upload as many as you want.</P>

                <FileUploader
                    cols={6}
                    colsOnMobile={3}
                    accept={"image/*"}
                    files={data.photos}
                    onToggleUploading={setIsUploading}
                    onAdd={(photo) => setData(data => ({...data, photos: [...data.photos, photo]}))}
                    onUpdate={(photos) => { setData(data => ({...data, photos})) }}
                />

                <PrimaryButton onClick={submit} disabled={isSubmitting || isUploading || ( isOnboarding && !data.skills.length)}>
                    { isSubmitting ? `Please wait...` : isOnboarding ? 'Continue' : 'Save' }
                </PrimaryButton>
        </CleanLayout>
    )
}
