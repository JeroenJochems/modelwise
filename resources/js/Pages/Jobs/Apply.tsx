import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";
import {InlinePhotoUploader} from "@/Components/InlinePhotoUploader";
import {P} from "@/Components/Typography/p";
import {Job} from "@/types/models";

type Props = {
    viewModel: {
        job: Job
    }
}


export default function Apply({ viewModel }: Props) {

    const {job} = viewModel;

    function test() {
    }

    return (
        <CleanLayout>
            <div className={"grid grid-cols-1 gap-4"}>


                <p className={"text-teal"}>Apply</p>
                <h1 className={'text-4xl'}>{job.title}</h1>
                <p>{job.description}</p>

                <hr className={"my-4"} />

                <P>Upload your most relevant photos for this shoot.</P>
                <InlinePhotoUploader photos={[]} onAddPhoto={test} cols={3} slots={9} onDeletePhoto={test} onUpdateSorting={test} />


                <Link href={route('jobs.apply', job.id)} className={"bg-teal rounded block text-center mt-4 p-2 text-white"}>
                    Apply
                </Link>
            </div>
        </CleanLayout>
    )
}
