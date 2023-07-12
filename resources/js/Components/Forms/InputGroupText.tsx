import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";

type Props =
    {
        name?: string,
        type?: string,
        value?: string,
        options?: Array<string>,
        title: string,
        autoComplete?: string,
        onChange: (value: string) => void,
        error?: string
        placeholder?: string
    }


export default function InputGroupText(props: Props) {

    const type = props.type ?? 'text';
    const value = props.value ?? "";
    const name = props.name ?? props.title.toLowerCase().replace(' ', '_');

    const shouldShowSelect = props.options && props.options.length > 0;

    return (
        <div>
            <InputLabel htmlFor={name} value={props.title}/>

            {shouldShowSelect && !!props.options &&
                <select id={name}
                             className="border-gray-300 focus:border-green focus:ring-green rounded-sm shadow-sm block mt-1 w-full"
                             value={value}
                             onChange={(e) => props.onChange(e.target.value)}>
                    {props.options.map((option: any) =>
                        <option key={option} value={option}>{option}</option>
                    )}
                </select>
            }

            {!shouldShowSelect &&
                <TextInput id={name} className="block mt-1 w-full" type={type} value={value}
                           onChange={(e) => props.onChange(e.target.value)}
                           autoComplete={props.autoComplete ?? name}/>
            }
            {!!props.error && <InputError message={props.error} className="mt-2"/>}
        </div>
    )
}
