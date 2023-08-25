import InviteData = Domain.Jobs.Data.InviteData;
import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";

type Props = {
    invites: InviteData[]
}

export function Invites({ invites }: Props) {

    return (
        <>
            <H2>{ invites.length } pending { invites.length===1 ? "invite" : "invites"}</H2>

            { invites.length > 0 &&
                <ul className={"mb-8"}>
                    <P></P>
                    {invites.map(invite =>
                        <li>
                            <a href={route("roles.show", invite.role.id)}>
                                {invite.role.name} at {invite.role.job.title}
                            </a>
                        </li>
                    )}
                </ul>
            }
        </>
    )
}
