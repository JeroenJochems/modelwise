import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import HireData = Domain.Jobs.Data.HireData;

type Props = {
    hires: HireData[]
}

export function Hires({ hires }: Props) {

    return (
        <>
            <H2>{ hires.length } { hires.length===1 ? "hire" : "hires"}</H2>

            { hires.length > 0 &&
                <ul className={"mb-8"}>
                    {hires.map(hire =>
                        <li>
                            <a href={route("roles.show", hire.application.id)}>
                                {hire.application.role.job.title}
                            </a>
                        </li>
                    )}
                </ul>
            }
        </>
    )
}
