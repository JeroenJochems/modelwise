import {ButtonHTMLAttributes} from "react";
import {RightArrow} from "@/Components/Icons/RightArrow";

export const Submit = (props: ButtonHTMLAttributes<HTMLButtonElement>) => {

    return (
        <button {...props} type="submit" className={`p-2 bg-teal flex justify-between hover:bg-teal-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:bg-teal-light active:bg-teal-light focus:outline-none transition ease-in-out duration-150 ${props.disabled && `opacity-25 `} ` + props.className}>
            <span>&nbsp;</span>
            <span className={'pt-1 align-middle'}>
                {props.children}
            </span>
            <RightArrow />
        </button>
    );
}
