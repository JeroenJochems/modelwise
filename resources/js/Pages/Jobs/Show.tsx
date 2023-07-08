import CleanLayout from "@/Layouts/CleanLayout";
import {Link} from "@inertiajs/react";

type Props = {
    job: {
        id: number,
        title: string,
        description: string,
        brand?: {
            name: string,
        },
    }
}

export default function Show({ job }: Props) {
    return (
        <CleanLayout>
            <p className={"text-green"}>Job description</p>
            <h1 className={'text-4xl'}>{job.title}</h1>
            <p>{job.description}</p>
            <p>{!!job.brand && job.brand.name}</p>

            <Link href={route('jobs.apply', job.id)} className={"bg-black rounded block text-center mt-2 p-2 text-white"}>
                Apply
            </Link>
        </CleanLayout>
    )
}
