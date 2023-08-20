
export const H3 = (props: React.HTMLProps<Text>) => {
    return (
        <h2 className={`text-lg ` + props.className}>
            {props.children}
        </h2>
    );
}
