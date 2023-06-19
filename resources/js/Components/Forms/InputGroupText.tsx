import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {ChangeEvent, HTMLProps} from "react";

export default function InputGroupText(props: HTMLProps<HTMLElement> & { name?: string, value: string, title: string, autoComplete: string|null, onChange: (e: ChangeEvent<HTMLInputElement>) => void, error?: string }) {

    return (
        <div>
            <InputLabel htmlFor={props.name  ?? props.title.toLowerCase().replace(' ', '_')} value={props.title}/>
            <TextInput id="first_name" className="block mt-1 w-full" value={props.value}
                       onChange={props.onChange}
                       autoComplete={props.autoComplete} required/>
            {!!props.error && <InputError message={props.error} className="mt-2"/> }
        </div>
    )
}
