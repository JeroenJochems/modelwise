import CleanLayout from "@/Layouts/CleanLayout";
import {Header} from "@/Components/Onboarding/Header";
import {H1} from "@/Components/Typography/H1";
import {Link, router, useForm, usePage} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import PrimaryButton from "@/Components/PrimaryButton";
import {PageProps} from "@/types";

type Country = {
    code: string
    name: string
}

type Props = {
    viewModel: App.ViewModels.ModelExclusiveCountriesViewModel
    modelingCountries: Country[]
    allCountries: Country[]
}

export default function ExclusiveCountries({viewModel, modelingCountries, allCountries }: Props) {

    const { ziggy, cdn_url } = usePage<PageProps>().props

    const { data, setData } = useForm({
        country: '',
    });

    function addSelectedCountry(country: string) {
        router.post(
            route('account.exclusive-countries.store'),
            { country },
            {
                preserveState: false,
                onSuccess: () => {
                    setData('country', '');
                }
            }
        )
    }

    const isOnboarding = ziggy.location.includes("onboarding");

    function getFlagEmoji(countryCode: string) {
        const codePoints = countryCode
            .toUpperCase()
            .split('')
            .map((char) =>  127397 + char.charCodeAt(0));
        return String.fromCodePoint(...codePoints);
    }

    return (
        <CleanLayout>
            <Header step={8} isOnboarding={isOnboarding} />

            <H1>Exclusive countries</H1>
            <P>Have you exclusively signed with another agency for specific countries? You can add them here so you
                don't receive unwanted invites to jobs.</P>

            <select id={"country"}
                    onChange={(e) => addSelectedCountry(e.target.value)}
                    className={"border-gray-300 focus:border-green focus:ring-green rounded-sm shadow-sm block mr-4 w-full"}>
                <option value={""}>Select a country...</option>
                { modelingCountries.map(({ code, name} ) => (
                    <option key={code} value={code} >{name}</option>
                ))}
            </select>

            <div className={"border border-1 rounded-sm mb-4"}>
                { viewModel.countryCodes.sort((one, two) => (one < two ? -1 : 1)).map((countryCode) => (
                    <div key={countryCode} className="flex justify-between group p-4 border-b-1 border-b">
                        { getFlagEmoji(countryCode) }
                        { allCountries.find((country) => country.code===countryCode)?.name }

                        <Link as={'button'} only={['viewModel']} href={route('account.exclusive-countries.delete', { country: countryCode })} method={"delete"} className={"text-gray-400 group-hover:text-gray-800 ml-auto"}>Remove</Link>
                    </div>
                ))}
            </div>

            <PrimaryButton onClick={() => router.visit(route(isOnboarding ? "onboarding.exclusive-countries.done" : 'account.index'))}>
                Continue
            </PrimaryButton>
        </CleanLayout>
    )
}
