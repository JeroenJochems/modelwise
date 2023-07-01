import {ButtonHTMLAttributes} from "react";

export const Submit = (props: ButtonHTMLAttributes<HTMLButtonElement>) => {
    return (
        <button {...props} type="submit" className={`p-4 bg-teal hover:bg-teal-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:bg-teal-light active:bg-teal-light focus:outline-none transition ease-in-out duration-150 ` + props.className}>
            {props.children}
        </button>
    );
}
