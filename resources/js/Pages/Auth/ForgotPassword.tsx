import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, useForm} from '@inertiajs/react';
import {FormEventHandler} from 'react';
import CleanLayout from "@/Layouts/CleanLayout";
import {asset} from "laravel-vapor";

export default function ForgotPassword({status}: { status?: string }) {
    const {data, setData, post, processing, errors} = useForm({
        email: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <CleanLayout>
            <Head><title>Forgot Password</title></Head>



            <div className="grid gap-4 mb-4 text-sm text-gray-600">
                <img src={asset("img/logo-black.svg")} className={"mb-4 w-1/2 mx-auto"} />

                Forgot your password? No problem. Just let us know your email address and we will email you a password
                reset link that will allow you to choose a new one.
            </div>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2"/>

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ml-4" disabled={processing}>
                        Email Password Reset Link
                    </PrimaryButton>
                </div>
            </form>
        </CleanLayout>
    );
}
