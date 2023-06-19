import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import {HTMLProps} from "react";

export default function InputGroupText(props: HTMLProps<typeof TextInput> & { name: string, value: string, title: string, autoComplete: string, onChange: () => {}, error?: string }) {

    return (
        <div>
            <InputLabel htmlFor={props.name} value={props.title}/>
            <TextInput id="first_name" className="block mt-1 w-full" value={props.value}
                       onChange={props.onChange}
                       autoComplete={props.autoComplete} required/>
            {!!props.error && <InputError message={props.error} className="mt-2"/> }
        </div>
    )
}
