import {H2} from "@/Components/Typography/H2";
import {H1} from "@/Components/Typography/H1";
import RoleData = Domain.Models.Data.RoleData;

type Props = {
    role: RoleData;
}

export function JobHeader({ role }: Props ) {

    const { job } = role;

    return (
        <div className={"flex p-4 bg-gray-800 flex-col text-center justify-center items-center"}>
            { !!job.brand?.logo && <img className={"mb-4 rounded-lg"} src={`${job.brand.logo}?h=60`} /> }

            <H2 className={"text-white"}>{role.name}</H2>
            <H1 className={"text-white"}>{job.title}</H1>

            <div className={"mt-4 flex flex-row items-center "}>
                <div className={"bg-gray-100 px-4 py-2 text-xs mx-2 rounded-full"}>
                    🗓️ { new Date(role.start_date).toLocaleDateString() }
                </div>
                <div className={"bg-gray-100 px-4 py-2 text-xs rounded-full"}>🌎 Amsterdam</div>
            </div>
        </div>
    )

}
