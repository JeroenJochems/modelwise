import ProposalModel from "@/Components/Organisms/ProposalModel";
import {H2} from "@/Components/Typography/H2";
import {useState} from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import {router} from '@inertiajs/react'
import {ApplicationData} from "@/types/generated";

type Props =  {
    presentation: any,
    role: any,
    applications: ApplicationData[]
}

export default function Show({ presentation, role, applications}: Props)
{
    const initialSelection = applications.filter(a => a.is_prelisted);

    const [selected, setSelected] = useState<ApplicationData[]>(initialSelection);

    const handleSelect = (application: ApplicationData) => {
        setSelected((prev) => {
            if (prev.includes(application)) {
                return prev.filter((app) => app !== application);
            }

            return [...prev, application];
        })
    }

    function concat(applications: ApplicationData[]) {
        const names = applications.map(application => application.model.first_name);

        if (names.length === 0) return 'no models'
        if (names.length === 1) return names[0];
        if (names.length === 2) return names.join(" and ");
        if (names.length < 6) return names.slice(0, -1).join(", ") + ", and " + names.slice(-1);

        return names.length + " models";
    }

    function handleSubmit() {
        router.post(`/presentations/${presentation.id}/prelist`, { prelist: selected.map(application => application.id) });
    }

    const hasSelectionChanged = selected.map(a=>a.id).sort().join('-') !== initialSelection.map(b=>b.id).sort().join('-')

    return (
        <div className={"flex h-screen-safe flex-col overflow-hidden relative"}>
            <div className="overflow-scroll flex-grow mt-8 px-4 py-12 sm:px-6 lg:px-8">

                <div className={"mx-auto max-w-2xl  lg:max-w-7xl"}>
                    <h1 className={"font-bold text-2xl sm:text-4xl mt-4"}>Proposal</h1>
                    <H2>{role.name} {role.job.title}</H2>

                    <div className={"flex flex-col gap-8 mt-16"}>
                        {applications.map(application => <ProposalModel
                            presentation={presentation}
                            application={application}
                            onSelect={handleSelect}
                            isSelected={selected.some(app => app.id === application.id)}
                            key={application.id}
                        />)}
                    </div>
                </div>
            </div>

            <div className={"p-4"}>
                <div className={"mx-auto max-w-2xl  lg:max-w-7xl"}>
                    { hasSelectionChanged && (
                        <PrimaryButton onClick={handleSubmit} className={"w-full"}>
                            Favorite {concat(selected)}
                        </PrimaryButton>
                    )}
                </div>
            </div>
        </div>
    )
}
