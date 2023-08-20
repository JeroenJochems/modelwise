import {HTMLProps} from "react";

type Props = {
    title: string;
    val: string;
    colspan?: number;
    className?: string;
}

export function Item({ title, val, className }: Props) {

    return (

        <div className={`p-4 sm:col-span-1 sm:px-0  bg-gray-100 rounded-lg ${className}`}>
            <dt className="text font-bold leading-6 sm:mx-4 text-gray-900">
                {title}
            </dt>
            <dd className="mt-1 leading-6 text-gray-700 sm:mx-4 ">
                {val}
            </dd>
        </div>
    )
}
