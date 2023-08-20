export const H1 = (props: React.HTMLProps<Text>) => {
    return (
        <h1 className={`font-bold text-xl sm:text-3xl ` + props.className}>
            {props.children}
        </h1>
    );
}
