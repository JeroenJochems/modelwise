import {useEffect, FormEventHandler} from 'react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import {Head, Link, useForm} from '@inertiajs/react';
import {H1} from "@/Components/Typography/H1";
import CleanLayout from "@/Layouts/CleanLayout";
import {Header} from "@/Components/Onboarding/Header";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Register() {
    const {data, setData, post, processing, errors, reset} = useForm({
        email: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    return (
        <CleanLayout photos={["https://modelwise.imgix.net/assets/13.jpeg?fm=auto&w=1200"]} header={
            <Header step={1} isOnboarding={true}>
                <H1>Create your account</H1>
            </Header>
        }>
            <Head>
                <title>Register</title>
            </Head>

            <form className="grid gap-4">

                <div>
                    <InputLabel htmlFor="email" value="Email"/>
                    <TextInput id="email" className="block mt-1 w-full" value={data.email}
                               onChange={(e) => setData('email', e.target.value)}
                               autoComplete="email" required/>
                    <InputError message={errors.email} className="mt-2"/>
                </div>

                <div>
                    <InputLabel htmlFor="password" value="Password"/>
                    <TextInput id="password" className="block mt-1 w-full" value={data.password} type="password"
                               onChange={(e) => setData('password', e.target.value)}
                               autoComplete="new-password" required/>
                    <InputError message={errors.password} className="mt-2"/>
                </div>

                <div>
                    <InputLabel htmlFor="password_confirmation" value="Confirm password"/>
                    <TextInput id="password_confirmation" className="block mt-1 w-full"
                               onChange={(e) => setData('password_confirmation', e.target.value)}
                               value={data.password_confirmation} type="password" autoComplete="new-password"
                               required/>
                    <InputError message={errors.password_confirmation} className="mt-2"/>
                </div>


                <PrimaryButton onClick={submit}>
                    Register
                </PrimaryButton>

                <Link href={route('login')} className={"text-center text-sm"}>
                    Already registered?
                </Link>
            </form>
        </CleanLayout>);
}
