import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link } from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {CtaLink} from "@/Components/CtaLink";
import {CheckIcon} from "@heroicons/react/24/outline";


export default function Index() {

    return (
        <CleanLayout mobileSplit>
            <div className="grid grid-cols-1 gap-4">
                <H1>Join the tribe!</H1>
                <P>You’re just a few steps away from a happier model life.</P>
                <P>Join the most transparent model booking platform. We want you to thrive and succeed and make sure you
                    get all the right support along the way. We’re here for you.</P>

                <div className={"mb-4 grid gap-4"}>
                    <P className={"mt-4 text-teal font-bold flex"}>
                        <CheckIcon className={"text-green h-6 w-6 mr-2"} />
                        <div className={"flex flex-col"}>
                            <span>0% commission or hidden fees for models</span>
                            <small className={"font-normal"}>Don’t take our word for it, we’ll prove it</small>
                        </div>
                    </P>
                    <P className={"text-teal flex font-bold"}>
                        <CheckIcon className={"text-green h-6 w-6 mr-2"} />
                        Fast payments
                    </P>
                    <P className={"text-teal flex font-bold"}>
                        <CheckIcon className={"text-green h-6 w-6 mr-2"} />
                        Efficient booking process
                    </P>
                    <P className={"text-teal flex font-bold"}>
                        <CheckIcon className={"text-green h-6 w-6 mr-2"} />
                        <div className={"flex flex-col"}>
                            <span>No unnecessary casting video's</span>
                            <small className={"font-normal"}>We aim for a 1:3 success ratio</small>
                        </div>
                    </P>
                    <P className={"text-teal flex font-bold"}>
                        <CheckIcon className={"text-green h-6 w-6 mr-2"} />
                        Exposure to leading brands and production companies
                    </P>
                </div>

                <CtaLink href={route("register")} title={"Sign up for free"} />

                <Link href={route('login')} className={"block w-full p-4 mt-4 text-center text-sm"}>
                    Already have an account? <span className={"underline"}>Log in</span>
                </Link>

            </div>
        </CleanLayout>
    )
}
