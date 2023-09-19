import CleanLayout from "@/Layouts/CleanLayout";
import {Header} from "@/Components/Onboarding/Header";
import {H1} from "@/Components/Typography/H1";
import {useForm, usePage} from '@inertiajs/react';
import {PageProps} from "@/types";
import ProfessionalExperienceViewModel = App.ViewModels.ProfessionalExperienceViewModel;
import {P} from "@/Components/Typography/p";
import {TagCloud} from "@/Components/TagCloud";
import PrimaryButton from "@/Components/PrimaryButton";

type Props = {
    vm: ProfessionalExperienceViewModel,
}

type FormData = {
    categories: string[],
    professions: string[],
    otherCategories: string | null
}

export default function ProfessionalExperience({vm}: Props) {
    const {ziggy} = usePage<PageProps>().props
    const isOnboarding = ziggy.location.includes("onboarding");

    const {data, setData, post} = useForm<FormData>({
        categories: vm.selectedCategories,
        professions: vm.selectedProfessions,
        otherCategories: vm.otherCategories,
    });

    function toggleCategory(slug: string) {
        if (data.categories.includes(slug)) {
            setData("categories", [...data.categories.filter(item => item !== slug)]);
        } else {
            setData("categories", [...data.categories, slug]);
        }
    }

    function toggleProfessions(slug: string) {
        if (data.professions.includes(slug)) {
            setData("professions", [...data.professions.filter(item => item !== slug)]);
        } else {
            setData("professions", [...data.professions, slug]);
        }
    }

    function submit() {
        post(ziggy.location);
    }

    return (
        <CleanLayout
            header={
                <Header step={9} isOnboarding={isOnboarding}>
                    <H1>Professional experience</H1>
                </Header>
            }
            photos={["https://modelwise.imgix.net/assets/7.4.jpg?w=1200&fm=auto"]}>

            <P>What kind of professional experience do you have?</P>
            <TagCloud tags={vm.allCategories}
                      includeOther={true}
                      onSetOther={(value) => setData("otherCategories", value || null)}
                      selected={data.categories}
                      otherValue={data.otherCategories || ""}
                      onToggle={toggleCategory}/>

            <P>Additionally, do you have professional experience in any of these categories?</P>
            <TagCloud tags={vm.allProfessions} selected={data.professions} onToggle={toggleProfessions}/>

            <PrimaryButton onClick={submit} className={"mt-8"}>
                {isOnboarding ? "Continue" : "Save"}
            </PrimaryButton>
        </CleanLayout>
    )
}
