import { FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link, useForm} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {LinkButton} from "@/Components/Atoms/LinkButton";


export default function Thanks({ is_subscribed}: {is_subscribed: boolean}) {

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
                <H1>Application submitted!</H1>
            </div>
        }>
            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <P>Awesome! Your application is submitted and will be reviewed within 3 working days. Once it has been evaluated, we will contact you.</P>
                { !is_subscribed && <P>In the meantime, subscribe to our newsletter to receive the latest Modelwise updates.</P> }
            </div>


            { !is_subscribed && (
                <form onSubmit={submit} className={"grid gap-4"}>
                    <Submit>
                        Sign up for newsletter
                    </Submit>
                </form>
            )}

            <LinkButton href={route('dashboard')} caption={"Go to dashboard"} />

        </CleanLayout>
    )
}
