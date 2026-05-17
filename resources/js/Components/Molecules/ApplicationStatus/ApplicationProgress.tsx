import {ListingData} from "@/types/generated";
import {CheckIcon} from "@heroicons/react/24/solid";
import clsx from "clsx";

type Props = {
    listing: ListingData;
};

type Stage = {
    key: string;
    label: string;
    reachedAt: string | null;
};

export function ApplicationProgress({listing}: Props) {
    const isRejected = !!listing.rejected_at;
    const isHired = !!listing.hired_at;

    const stages: Stage[] = [
        {key: 'applied', label: 'Applied', reachedAt: listing.applied_at},
        {key: 'shortlisted', label: 'Shortlisted', reachedAt: listing.shortlisted_at},
        {key: 'sent', label: 'Sent to client', reachedAt: listing.extended_application_at},
        {
            key: 'decided',
            label: isRejected ? 'Not selected' : 'Hired',
            reachedAt: listing.hired_at ?? listing.rejected_at,
        },
    ];

    const lastReachedIndex = stages.reduce(
        (acc, stage, idx) => (stage.reachedAt ? idx : acc),
        -1
    );

    return (
        <ol className="flex items-start gap-1 w-full pb-2" aria-label="Application progress">
            {stages.map((stage, idx) => {
                const reached = idx <= lastReachedIndex;
                const isCurrent = idx === lastReachedIndex;
                const isFailed = stage.key === 'decided' && isRejected && reached;

                return (
                    <li key={stage.key} className="flex-1 flex flex-col items-center min-w-0">
                        <div className="flex items-center w-full">
                            <div className={clsx(
                                "h-1 flex-1 rounded-full",
                                idx === 0 ? "invisible" :
                                reached ? (isFailed ? "bg-gray-300" : "bg-gradient-to-r from-teal to-teal-light") :
                                "bg-gray-200"
                            )} />
                            <div className={clsx(
                                "shrink-0 h-8 w-8 rounded-full flex items-center justify-center text-sm font-medium transition shadow-outline",
                                isFailed ? "bg-gray-400 text-white" :
                                reached ? "bg-gradient-to-br from-teal to-teal-light text-white" :
                                "bg-white text-gray-400 ring-1 ring-gray-200",
                                isCurrent && !isHired && !isRejected && "ring-2 ring-teal ring-offset-2 ring-offset-white"
                            )}>
                                {reached
                                    ? (isFailed ? '✕' : <CheckIcon className="h-4 w-4" strokeWidth={3} />)
                                    : idx + 1}
                            </div>
                            <div className={clsx(
                                "h-1 flex-1 rounded-full",
                                idx === stages.length - 1 ? "invisible" :
                                idx < lastReachedIndex ? (isFailed ? "bg-gray-300" : "bg-gradient-to-r from-teal to-teal-light") :
                                "bg-gray-200"
                            )} />
                        </div>
                        <span className={clsx(
                            "text-xs mt-3 text-center leading-tight px-1",
                            reached ? "text-teal font-medium" : "text-gray-400"
                        )}>
                            {stage.label}
                        </span>
                    </li>
                );
            })}
        </ol>
    );
}
