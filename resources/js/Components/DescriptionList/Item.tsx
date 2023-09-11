import {HTMLAttributes} from "react";

type Props = {
    title: string;
    val: string;
}

export function Item({ title, val, className }: Props & HTMLAttributes<HTMLDivElement>) {

    return (

        <div className={`p-4 sm:px-0  bg-teal-100 rounded-lg ${className}`}>
            <dt className="text leading-6 sm:mx-4 text-teal">
                {title}
            </dt>
            <dd className="mt-1 leading-6 text-gray-700 sm:mx-4 ">
                {val}
            </dd>
        </div>
    )
}
