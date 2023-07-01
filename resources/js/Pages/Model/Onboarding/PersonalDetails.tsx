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
import {asset} from "laravel-vapor";
import {Submit} from "@/Components/Forms/Submit";

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

    const {data, setData, post, clearErrors, errors } = useForm({
        ...modelData,
        country: modelData.country ?? "Netherlands",
        phone_number: modelData.phone_number ?? "+31",
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

    const countryCodes = [
        { name: "Netherlands", code: "+31"},
        { name: "Belgium", code: "+32"},
        { name: "Brazil", code: "+55"},
        { name: "Germany", code: "+49"},
        { name: "France", code: "+33"},
        { name: "Mexico", code: "+52"},
        { name: "Norway", code: "+47"},
        { name: "Portugal", code: "+351"},
        { name: "Spain", code: "+34"},
        { name: "Sweden", code: "+46"},
        { name: "South Africa", code: "+27"},
        { name: "United Kingdom", code: "+44"},
    ];


    function setCountry(country: string) {
        setData('country', country);

        if (data.phone_number.length < 6) {

            const countryObj = countryCodes.find(c => c.name === country);

            if (countryObj) {
                setData('phone_number', `${countryObj.code} `);
            }
        }
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
                    autoComplete={"given-name"}
                    onChange={(value: string) => { clearErrors('first_name'); setData('first_name', value) }}
                />

                <InputGroupText
                    title="Last name"
                    value={data.last_name}
                    error={errors.last_name}
                    autoComplete={"family-name"}
                    onChange={(value: string) => { clearErrors('last_name'); setData('last_name', value) }}
                />

                <InputGroupText
                    title="Birth date"
                    type={"date"}
                    value={data.date_of_birth}
                    error={errors.date_of_birth}
                    onChange={(value: string) => { clearErrors('date_of_birth'); setData('date_of_birth', value) }}
                />

                <InputGroupText
                    title="Gender"
                    value={data.gender}
                    options={genderOptions}
                    error={errors.gender}
                    onChange={(value: string) => { clearErrors('gender'); setData('gender', value) }}
                />

                <InputGroupText
                    title="Country"
                    value={data.country}
                    options={countryCodes.map(c => c.name)}
                    error={errors.country}
                    onChange={(value: string) => { setCountry(value) }}
                />

                <InputGroupText
                    title="City"
                    value={data.city}
                    error={errors.city}
                    onChange={(value: string) => { clearErrors('city'); setData('city', value); } }
                />

                <InputGroupText
                    title="Phone number"
                    value={data.phone_number}
                    error={errors.phone_number}
                    onChange={(value: string) => { clearErrors('phone_number'); setData('phone_number', value) }}
                />



                <Submit>
                    Continue
                </Submit>
            </form>
        </CleanLayout>
    )
}
