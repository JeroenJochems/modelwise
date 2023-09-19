import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {JobSpecifics} from "@/Components/Molecules/JobSpecifics";
import {CtaLink} from "@/Components/CtaLink";
import {getRoleLabel} from "@/Utils/RoleLabel";
import {Label} from "@/Components/Atoms/Label";
import {useCdnLink} from "@/Hooks/useCdnLink";

type Props = {
    role: Domain.Jobs.Data.RoleData
}

export function DashboardRole({ role }: Props) {

    const cdnLink = useCdnLink()
    const photos = [...role.public_photos, ...role.job.look_and_feel_photos];

    return (
        <li className={"block bg-white/95 shadow-outline overflow-hidden rounded-lg flex"}>
            <div className={"w-2/3 grid gap-4 p-4 my-4 flex-grow"}>

                <Label>{getRoleLabel(role)}</Label>

                <H2 className={"font-bold"}>{ role.job.title}</H2>

                <P lineClamp={3}>{ role.job.description}</P>

                <JobSpecifics role={ role}/>

                <div className={"flex"}>
                    <CtaLink
                        title={"Show details"}
                        className={"bg-teal p-4 rounded text-white"}
                        href={role.my_application
                             ? route("applications.show", role.my_application)
                             : route("roles.show", role)
                            } />
                </div>
            </div>
            <div className={"hidden md:flex max-w-xs"}>
                <img src={cdnLink(photos[0].path, "face_square")} className={"h-full w-full object-cover"} />
            </div>
        </li>
    )
}
