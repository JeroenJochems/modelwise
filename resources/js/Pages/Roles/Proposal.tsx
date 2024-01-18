import ProposalModel from "@/Components/Organisms/ProposalModel";
import {H2} from "@/Components/Typography/H2";


export default function Show({ presentation, role, applications})
{
    return (
        <div className="mx-auto mt-8 max-w-2xl px-4 py-12 sm:px-6 lg:max-w-7xl lg:px-8">

            <h1 className={"font-bold text-3xl sm:text-6xl mt-4"}>Proposal</h1>
            <H2>{ role.name } { role.job.title}</H2>

            { applications.map(application => <ProposalModel
                presentation={presentation}
                application={application}
            />) }
        </div>
    )
}
