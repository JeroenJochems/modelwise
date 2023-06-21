import {ChangeEvent, FormEvent, FormEventHandler} from "react";
import CleanLayout from "@/Layouts/CleanLayout";
import {Step} from "@/Components/Onboarding/Step";
import {H1} from "@/Components/Typography/H1";
import InputGroupText from "@/Components/Forms/InputGroupText";
import PrimaryButton from "@/Components/PrimaryButton";
import {Link, router, useForm} from '@inertiajs/react';
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {P} from "@/Components/Typography/p";
import SecondaryButton from "@/Components/SecondaryButton";


export default function Thanks() {


    return (
        <CleanLayout>
            <div className="grid grid-cols-1 gap-4 mb-8 mt-8">
                <H1>Application rejected</H1>
                <P>Sadly, your application to Modelwise has not been accepted.</P>
            </div>
        </CleanLayout>
    )
}
