import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link } from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {CtaLink} from "@/Components/CtaLink";


export default function Index() {

    return (
        <CleanLayout photos={["assets/10.png"]}>
            <div className="grid grid-cols-1 gap-4">
                <H1>Join the tribe!</H1>
                <P>You’re just a few steps away from a happier model life.</P>
                <P>Join the most transparent model booking platform. We want you to thrive and succeed and make sure you
                    get all the right support along the way. We’re here for you.</P>

                <P className={"mt-4 text-teal font-bold"}>0% commission or other fees <br /><small className={"font-normal"}>PS: don’t take our word for it, we’ll prove it</small></P>
                <P className={"text-teal font-bold"}>Fast payments</P>
                <P className={"text-teal font-bold"}>Fast and streamlined bookings</P>
                <P className={"text-teal font-bold"}>No unnecessary casting video's
                    <br /><small className={"font-normal"}>we aim for 1/3 success rate</small></P>

                <CtaLink href={route("register")} title={"Sign up for free"} />

                <Link href={route('login')} className={"block w-full p-4 mt-4 text-center text-sm"}>
                    Already have an account? <span className={"underline"}>Log in</span>
                </Link>

            </div>
        </CleanLayout>
    )
}
