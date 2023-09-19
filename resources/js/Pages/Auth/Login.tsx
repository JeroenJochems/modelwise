import { useEffect, FormEventHandler } from 'react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, useForm} from '@inertiajs/react';
import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {asset} from "laravel-vapor";
import {CtaLink} from "@/Components/CtaLink";
import {P} from "@/Components/Typography/p";
import {H3} from "@/Components/Typography/H3";
import {H2} from "@/Components/Typography/H2";

export default function Login({ status, canResetPassword }: { status?: string, canResetPassword: boolean }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <CleanLayout photos={['https://modelwise.imgix.net/assets/2.jpeg?fm=auto&w=1200']}>
            <Head title="Log in" />

            <img src={asset("img/logo-black.svg")} className={"mb-4 w-1/2 mx-auto lg:hidden"} />

            <div className={"grid gap-8"}>
                <H1>Hello! Have you registered yet?</H1>

                {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

                    <form onSubmit={submit}>
                        <div>
                            <InputLabel htmlFor="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="username"
                                isFocused={true}
                                onChange={(e) => setData('email', e.target.value)}
                            />

                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="password" value="Password" />

                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full"
                                autoComplete="current-password"
                                onChange={(e) => setData('password', e.target.value)}
                            />

                            <InputError message={errors.password} className="mt-2" />
                        </div>

                        <div className="block mt-4">
                            <label className="flex items-center">
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                />
                                <span className="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <div className="flex flex-col justify-between mt-4">


                            <PrimaryButton disabled={processing}>
                                LOG IN
                            </PrimaryButton>

                            <div className={"grid gap-4 mt-8"}>
                                {canResetPassword && (
                                    <Link
                                        href={route('password.request')}
                                        className="hover:text-gray-900 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Forgot your password?
                                    </Link>
                                )}
                            </div>
                        </div>
                    </form>

                <div className="relative flex py-4 items-center">
                    <div className="flex-grow border-t border-gray-400"></div>
                    <span className="flex-shrink mx-4 text-gray-400">Or</span>
                    <div className="flex-grow border-t border-gray-400"></div>
                </div>

                <CtaLink title="SIGN UP" href={route("onboarding.index")} />
            </div>
        </CleanLayout>
    );
}
