
export const H2 = (props: React.HTMLProps<Text>) => {
    return (
        <h2 className={`text-xl ` + props.className}>
            {props.children}
        </h2>
    );
}
