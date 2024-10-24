import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import TextArea from "@/Components/TextArea";
import {HTMLAttributes} from "react";

type Props = {
    name?: string,
    type?: string,
    value?: string | number | null,
    options?: Array<string>,
    title: string,
    autoComplete?: string,
    onChange: (value: string) => void,
    error?: string
    placeholder?: string
    multiline?: boolean
}


export default function InputGroupText(props: Props) {

    const type = props.type ?? 'text';
    const value = props.value ?? "";
    const options = props.options ?? null;
    const name = props.name ?? props.title.toLowerCase().replace(' ', '_');

    const shouldShowSelect = props.options;

    return (
        <div>
            <InputLabel htmlFor={name} value={props.title}/>

            {props.multiline && <TextArea defaultValue={value} onChange={(e) => props.onChange(e.target.value)}/>}

            {!props.multiline && shouldShowSelect && options!==null &&
                <select id={name}
                        value={value}
                        className="border-gray-300 focus:border-green focus:ring-green rounded-sm shadow-sm block mt-1 w-full"
                        onChange={(e) => props.onChange(e.target.value)}>

                    {!value && <option value=""> - select an option -</option>}
                    {options.constructor.name === 'Array' && options.map((option: any) =>
                        <option key={option} value={option}>{option}</option>
                    )}
                    {options.constructor.name === 'Object' && Object.keys(options).map((option: any) =>
                        <option key={option} value={option}>{options[option]}</option>
                    )}
                </select>
            }

            {!props.multiline && !shouldShowSelect &&
                <TextInput id={name} className="block mt-1 w-full" type={type} value={value}
                           onChange={(e) => props.onChange(e.target.value)}
                           autoComplete={props.autoComplete ?? name}/>
            }
            {!!props.error && <InputError message={props.error} className="mt-2"/>}
        </div>
    )
}
