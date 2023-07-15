import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";
import {Job} from "@/types/models";

type Props = {
    viewModel: {
        job: Job
    }
}

export default function Show({ viewModel }: Props) {

    const { job } = viewModel;

    return (
        <CleanLayout>
            <p className={"text-teal"}>Job description</p>
            <h1 className={'text-4xl'}>{job.title}</h1>
            <p>{job.description}</p>
            <p>{!!job.brand && job.brand.name}</p>

            <Link href={route('jobs.apply', job.id)} className={"bg-teal rounded block text-center mt-2 p-2 text-white"}>
                Apply
            </Link>
        </CleanLayout>
    )
}
