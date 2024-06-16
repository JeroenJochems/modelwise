import {P} from "@/Components/Typography/p";

import {H2} from "@/Components/Typography/H2";
import {RoleData} from "@/types/generated";

type Props =  {
    role: RoleData,
}

export default function PrelistSubmitted({ role }: Props)
{
    return (
        <div className={"flex h-screen-safe flex-col overflow-hidden relative"}>
            <div className="overflow-scroll flex-grow mt-8 px-4 py-12 sm:px-6 lg:px-8">

                <div className={"mx-auto max-w-2xl  lg:max-w-7xl"}>
                    <h1 className={"font-bold text-xl sm:text-4xl mt-4"}>Thank you.</h1>

                    <P className={"mt-8"}>Your preference has been submitted. We'll get back with you once we've made further progress.</P>
                </div>

            </div>
        </div>
    )
}
