import {ReactNode} from "react";
import {CheckIcon} from "@heroicons/react/24/solid";
import clsx from "clsx";

type Props = {
    number: number;
    title: string;
    status?: 'done' | 'in_progress' | 'pending';
    statusLabel?: string;
    instructions?: string | null;
    children?: ReactNode;
    isLast?: boolean;
};

export function StepRow({number, title, status = 'pending', statusLabel, instructions, children}: Props) {
    const done = status === 'done';

    return (
        <div className="flex gap-4">
            {/* Number / check bubble */}
            <div className={clsx(
                "shrink-0 h-9 w-9 rounded-full flex items-center justify-center font-medium text-sm transition",
                done
                    ? "bg-teal text-white"
                    : status === 'in_progress'
                    ? "bg-white text-teal ring-2 ring-teal"
                    : "bg-white text-gray-400 ring-1 ring-gray-200"
            )}>
                {done ? <CheckIcon className="h-4 w-4" strokeWidth={3} /> : number}
            </div>

            {/* Content */}
            <div className="flex-1 min-w-0 pt-1">
                <div className="flex items-baseline justify-between gap-3 flex-wrap mb-1">
                    <h3 className="font-medium text-teal text-lg tracking-tight">{title}</h3>
                    {statusLabel && (
                        <span className={clsx(
                            "text-xs font-medium px-2 py-1 rounded-full",
                            done ? "bg-green/15 text-teal" :
                            status === 'in_progress' ? "bg-teal-100 text-teal" :
                            "bg-gray-100 text-gray-600"
                        )}>{statusLabel}</span>
                    )}
                </div>
                {instructions && (
                    <div className="mb-3">
                        <p className="text-xs uppercase tracking-wide text-gray-500 mb-1">Instructions</p>
                        <p className="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{instructions}</p>
                    </div>
                )}
                {children}
            </div>
        </div>
    );
}
