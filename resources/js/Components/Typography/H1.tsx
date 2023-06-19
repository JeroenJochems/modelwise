type Props = {
    children: React.ReactNode;
}

export const H1 = (props: Props) => {
    return (
        <h1 className="text-2xl font-bold">
            {props.children}
        </h1>
    );
}
