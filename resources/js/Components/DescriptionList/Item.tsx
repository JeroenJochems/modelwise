type Props = {
    var: string;
    val: string;
    line2: string;
}

export function Item(props: Props) {

    return (

        <div className="px-2 py-4 sm:col-span-1 sm:px-0">
            <dt className="text font-bold leading-6 text-gray-900">{props.var}</dt>
            <dd className="mt-1 leading-6 text-gray-700 sm:mt-2">
                { props.val }
                { props.line2 && (
                    <>
                        <br />
                        { props.line2}
                    </>
                )}</dd>
        </div>
    )
}
