import { FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link, useForm, usePage} from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {Header} from "@/Components/Onboarding/Header";
import {PageProps} from "@/types";


export default function Experience() {

    const {ziggy} = usePage<PageProps>().props
    const isOnboarding = ziggy.location.includes("onboarding");

    return (
        <CleanLayout>
            <Header step={8} isOnboarding={isOnboarding} />

            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <H1>Professional background</H1>
                <P>Select which categories you are experienced in:</P>
            </div>


            <div className={"flex"}>
                <Link href={route('dashboard')} className={"block w-full p-4 mt-4 text-center text-sm"}>
                    Go to dashboard
                </Link>
            </div>

        </CleanLayout>
    )
}
