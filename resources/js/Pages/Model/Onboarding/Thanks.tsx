import { FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link, useForm, usePage} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {LinkButton} from "@/Components/Atoms/LinkButton";
import {PageProps} from "@/types";

type Props = {
    is_subscribed: boolean
}

export default function Thanks({ is_subscribed}: Props) {

    const {ziggy, auth} = usePage<PageProps>().props

    const { post } = useForm();

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('onboarding.subscribe'));
    }

    return (
        <CleanLayout mobileSplit header={
            <div className={"grid gap-4"}>
                <div className={"w-16"}>
                    <Link href={route("onboarding.professional-experience")} className={"w-16 text-gray-400"}>
                        &#9664; back
                    </Link>
                </div>
                <H1>All set, { auth.user.first_name } 🙌</H1>
            </div>
        }>
            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <P>Awesome! Your registration is submitted successfully. You're now officially part of the Modelwise tribe.</P>
                { !is_subscribed && <P>Don’t forget to subscribe to our newsletter to receive the latest platform updates, tips & tricks and much more.</P> }
            </div>


            { !is_subscribed && (
                <form onSubmit={submit} className={"grid gap-4"}>
                    <Submit>
                        Yes, sign me up to the newsletter
                    </Submit>
                </form>
            )}

            <Link className={"mx-auto mt-4 underline"} href={route('dashboard')}>Go to dashboard</Link>

        </CleanLayout>
    )
}
