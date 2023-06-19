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

type ModelDataType = {
    first_name: string
    last_name: string
    phone_number: string
    location: string
}

type Props = {
    modelData: ModelDataType
}

export default function PersonalDetails({modelData}: Props) {

    const {data, setData, post, errors } = useForm(modelData);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('onboarding.personal-details'));
    };

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
                    autoComplete="first_name"
                    onChange={(e: ChangeEvent<HTMLInputElement>) => setData('first_name', e.target.value)}
                />

                <InputGroupText
                    title="Last name"
                    value={data.last_name}
                    error={errors.last_name}
                    autoComplete="last_name"
                    onChange={(e: ChangeEvent<HTMLInputElement>) => setData('last_name', e.target.value)}
                />

                <InputGroupText
                    title="Phone number"
                    value={data.phone_number}
                    error={errors.phone_number}
                    autoComplete="phone_number"
                    onChange={(e: ChangeEvent<HTMLInputElement>) => setData('phone_number', e.target.value)}
                />

                <InputGroupText
                    title="Location"
                    value={data.location}
                    error={errors.location}
                    autoComplete="location"
                    onChange={(e: ChangeEvent<HTMLInputElement>) => setData('location', e.target.value)}
                />


                <PrimaryButton type="submit" className="w-full">
                    Continue
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
