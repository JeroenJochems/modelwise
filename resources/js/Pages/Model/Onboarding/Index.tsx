import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {Link } from '@inertiajs/react';
import {P} from "@/Components/Typography/p";
import {Submit} from "@/Components/Forms/Submit";
import {CtaLink} from "@/Components/CtaLink";


export default function Index() {

    return (
        <CleanLayout photo={"assets/10.png"}>
            <div className="grid grid-cols-1 gap-8">
                <H1>Welcome to Modelwise!</H1>
                <P>The only transparent and forward-thinking model booking platform. We want you to
                    thrive and succeed and make sure you get all the right support along the way. We're here for you.</P>

                <P className={"text-teal font-bold"}>0% commission or other fees</P>
                <P className={"text-teal font-bold"}>Set your own rates</P>
                <P className={"text-teal font-bold"}>Use our pre-made and verified contracts</P>
                <P className={"text-teal font-bold"}>Direct contact with brands</P>


                <CtaLink href={route("register")} title={"Register for free"} />

                <Link href={route('login')} className={"block w-full p-4 mt-4 text-center text-sm"}>
                    Already have an account? <span className={"underline"}>Log in</span>
                </Link>

            </div>
        </CleanLayout>
    )
}
