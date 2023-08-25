import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import ApplicationData = Domain.Jobs.Data.ApplicationData;

type Props = {
    applications: ApplicationData[]
}

export function OpenApplications({ applications }: Props) {

    return (
        <>
            <H2>{ applications.length } pending { applications.length===1 ? "application" : "applications"}</H2>

            { applications.length > 0 &&
                <ul>
                    <P></P>
                    {applications.map(application =>
                        <li>
                            <a href={route("roles.show", application.role.id)}>
                                {application.role.name} at {application.role.job.title}
                            </a>
                        </li>
                    )}
                </ul>
            }
        </>
    )
}
