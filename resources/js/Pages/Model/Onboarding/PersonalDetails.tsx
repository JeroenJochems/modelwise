import {FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {Header} from "@/Components/Onboarding/Header";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import {useForm, usePage} from '@inertiajs/react';
import {Submit} from "@/Components/Forms/Submit";
import {PageProps} from "@/types";
import CountriesViewModel = App.ViewModels.CountriesViewModel;
import PrimaryButton from "@/Components/PrimaryButton";

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
    modelData: ModelDataType,
    countriesViewModel: CountriesViewModel,
}

export default function PersonalDetails({modelData, countriesViewModel }: Props) {
    const { ziggy } = usePage<PageProps>().props

    const {data, setData, post, clearErrors, errors } = useForm({
        ...modelData,
        country: modelData.country ?? "Netherlands",
        phone_number: modelData.phone_number ?? "+31",
        date_of_birth: modelData.date_of_birth ? modelData.date_of_birth.split(' ')[0] : "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(ziggy.location);
    };

    let genderOptions = [
        'Male',
        'Female',
        'Non-binary',
    ]

    if (!modelData.gender) {
        genderOptions = ['', ...genderOptions];
    }


    function setCountry(country: string) {

        setData('country', country);

        if (data.phone_number.length < 6) {

            const countryObj = countriesViewModel.countries.find(c => c.name === country);

            if (countryObj) {
                setData({
                    ...data,
                    country,
                    phone_number: `+${countryObj.phone} `
                });
            }
        }
    }

    const isOnboarding = ziggy.location.includes("onboarding");

    return (
        <CleanLayout header={
            <Header step={2} isOnboarding={isOnboarding}>
                <H1>Personal details</H1>
            </Header>
        } photos={["https://modelwise.imgix.net/assets/18.jpeg"]}>

            <form className="grid gap-4">

                <InputGroupText
                    title="First name"
                    value={data.first_name ?? ""}
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
                    title="Date of birth"
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
                    options={countriesViewModel.countries.map(c => c.name)}
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

                <PrimaryButton onClick={submit}>
                    {isOnboarding ? "Continue" : "Save" }
                </PrimaryButton>
            </form>
        </CleanLayout>
    )
}
