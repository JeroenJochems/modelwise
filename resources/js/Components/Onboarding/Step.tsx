import {H2} from "@/Components/Typography/H2";

type Props = {
    step: number;
    totalSteps: number;
}

export const Step = ({step, totalSteps}: Props) => {

    return (
        <div>
            <H2 className="text-center mb-2">
                Step {step} of {totalSteps}
            </H2>

            <div className="w-full bg-gray-100 h-2 rounded-full">
                <div style={{ width: (step / totalSteps * 100) + '%'}}  className="bg-green h-2 rounded-full"></div>
            </div>
        </div>
    );
}
