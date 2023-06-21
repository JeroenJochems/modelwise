import {ChangeEvent, FormEvent, FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {Step} from "@/Components/Onboarding/Step";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import PrimaryButton from "@/Components/PrimaryButton";
import { useForm } from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {P} from "@/Components/Typography/p";

type ModelDataType = {
    first_name: string
    last_name: string
    phone_number: string
    city: string
    country: string
    gender: string
    date_of_birth: string
}

type Props = {
    modelData: ModelDataType
}

export default function PersonalDetails({modelData}: Props) {

    const {data, setData, post, errors } = useForm({
        ...modelData,
        date_of_birth: modelData.date_of_birth ? modelData.date_of_birth.split(' ')[0] : "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('onboarding.personal-details'));
    };

    let genderOptions = [
        'Male',
        'Female',
        'Non-binary',
    ]

    if (!modelData.gender) {
        genderOptions = ['', ...genderOptions];
    }



    return (
        <CleanLayout>
            <Step step={2} totalSteps={6} />

            <div className="grid grid-cols-1 gap-4 mt-8">
                <H1>Personal details</H1>
            </div>

            <form onSubmit={submit} className="grid gap-4">

                <InputGroupText
                    title="First name"
                    value={data.first_name}
                    error={errors.first_name}
                    onChange={(value: string) => setData('first_name', value)}
                />

                <InputGroupText
                    title="Last name"
                    value={data.last_name}
                    error={errors.last_name}
                    onChange={(value: string) => setData('last_name', value)}
                />

                <InputGroupText
                    title="Phone number"
                    value={data.phone_number}
                    error={errors.phone_number}
                    onChange={(value: string) => setData('phone_number', value)}
                />

                <InputGroupText
                    title="City"
                    value={data.city}
                    error={errors.city}
                    onChange={(value: string) => setData('city', value)}
                />

                <InputGroupText
                    title="Birth date"
                    type={"date"}
                    value={data.date_of_birth}
                    error={errors.date_of_birth}
                    onChange={(value: string) => setData('date_of_birth', value)}
                />


                <InputGroupText
                    title="Country"
                    value={data.country}
                    options={[
                        'Netherlands',
                        'Belgium',
                        'Brazil',
                        'Germany',
                        'France',
                        'Mexico',
                        'Norway',
                        'Portugal',
                        'Spain',
                        'Sweden',
                        'South Africa',
                        'United Kingdom',
                    ]}
                    error={errors.country}
                    onChange={(value: string) => setData('country', value)}
                />
                <InputGroupText
                    title="Gender"
                    value={data.gender}
                    options={genderOptions}
                    error={errors.gender}
                    onChange={(value: string) => setData('gender', value)}
                />


                <PrimaryButton type="submit" className="w-full">
                    Continue
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
