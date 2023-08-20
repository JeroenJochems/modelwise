import { ButtonHTMLAttributes } from 'react';
import {RightArrow} from "@/Components/Icons/RightArrow";

export default function PrimaryButton({ className = '', disabled, children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={
                `p-4 bg-teal flex justify-between border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:bg-teal-light active:bg-teal-light focus:outline-none transition ease-in-out duration-150 ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            <span>&nbsp;</span>
            <span className={'pt-1'}>
                {children}
            </span>
            <RightArrow />
        </button>
    );
}
