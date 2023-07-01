import {H2} from "@/Components/Typography/H2";
import {Link} from "@inertiajs/react";

type Props = {
    step: number;
    totalSteps: number;
    backLink?: string;
}

export const Step = ({step, totalSteps, backLink}: Props) => {

    return (
        <div>
            <div className="flex items-center justify-between mb-2">
                <div className={"w-16"}>
                    { !!backLink && (
                        <Link href={backLink} className={"w-16"}>
                            &lt; Back
                        </Link>
                    )}
                </div>
                <H2 className={"text-center"}>
                    Step {step} of {totalSteps}
                </H2>
                <div className={"w-16"}>

                </div>
            </div>

            <div className="w-full bg-gray-100 h-2 rounded-full">
                <div style={{ width: (step / totalSteps * 100) + '%'}}  className="bg-green h-2 rounded-full"></div>
            </div>
        </div>
    );
}
