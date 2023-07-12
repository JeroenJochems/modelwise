import CleanLayout from "@/Layouts/CleanLayout";
import {H1} from "@/Components/Typography/H1";
import {P} from "@/Components/Typography/p";


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
