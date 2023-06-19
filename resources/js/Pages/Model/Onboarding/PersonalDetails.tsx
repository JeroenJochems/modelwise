import CleanLayout from "@/Layouts/CleanLayout";
import {Step} from "@/Components/Onboarding/Step";
import {H1} from "@/Components/Typography/H1";
import {FormEvent, FormEventHandler } from "react";
import InputGroupText from "@/Components/Forms/InputGroupText";
import {useForm} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";

type ModelDataType = {
    first_name: string
    last_name: string
    phone_number: string
    location: string
}

export default function PersonalDetails({modelData}: { modelData: ModelDataType }) {

    const {data, setData, post, processing, errors, reset} = useForm({
        first_name: modelData.first_name,
        last_name: modelData.last_name,
        phone_number: modelData.phone_number,
        location: modelData.location
    });

    const submit: FormEventHandler = (e: FormEvent<HTMLFormElement>) => {
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
                    name="first_name"
                    title="First name"
                    value={data.first_name}
                    error={errors.first_name}
                    onChange={(e) =>  setData('first_name', e.target.value) }
                />

                <InputGroupText
                    name="last_name"
                    title="Last name"
                    value={data.last_name}
                    error={errors.last_name}
                    onChange={(e) => setData('last_name', e.target.value)}
                />

                <InputGroupText
                    name="phone_number"
                    title="Phone number"
                    value={data.phone_number}
                    error={errors.phone_number}
                    onChange={(e) => setData('phone_number', e.target.value)}
                />

                <InputGroupText
                    name="location"
                    title="Location"
                    value={data.location}
                    error={errors.location}
                    onChange={(e) => setData('location', e.target.value)}
                />

                <PrimaryButton type="submit" className="w-full">
                    Continue
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
