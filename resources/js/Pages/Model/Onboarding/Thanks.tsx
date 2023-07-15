import { FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link, useForm} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";


export default function Thanks({ is_subscribed}: {is_subscribed: boolean}) {

    const { post } = useForm();

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('onboarding.subscribe'));
    }

    return (
        <CleanLayout>
            <div className={"w-16"}>
                <Link href={route("onboarding.characteristics")} className={"w-16"}>
                    &lt; Back
                </Link>
            </div>
            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <H1>Application submitted!</H1>
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

            <div className={"flex"}>
                <Link href={route('dashboard')} className={"block w-full p-4 mt-4 text-center text-sm"}>
                    Go to dashboard
                </Link>
            </div>

        </CleanLayout>
    )
}
