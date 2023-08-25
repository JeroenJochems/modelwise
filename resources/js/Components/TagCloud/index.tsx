import {useRef, useState} from "react";
import TextInput from "@/Components/TextInput";
import {Tag} from "@/Components/Atoms/Tag";

type Props = {
    tags: {
        id: number;
        name: string;
        slug: string;
    }[],
    selected: string[],
    onToggle: (slug: string) => void

    includeOther?: boolean,
    otherValue?: string,
    onSetOther?: (value: string) => void,
}

export function TagCloud({tags, selected, onToggle, includeOther, onSetOther, otherValue }: Props) {

    const [otherSelected, setOtherSelected] = useState(!!otherValue);
    const otherValueRef = useRef<HTMLInputElement>(null);

    function toggleSelected() {
        setOtherSelected(!otherSelected);

        otherValueRef.current?.focus();
    }

    function changeOtherValue(e: React.ChangeEvent<HTMLInputElement>) {
        if (onSetOther) {
            onSetOther(e.target.value);
        }
    }

    return (
        <div className={"select-none"}>
            {tags.map(function (tag) {

                return <Tag
                    key={tag.slug}
                    slug={tag.slug}
                    isActive={selected.includes(tag.slug)}
                    onToggle={onToggle}>{tag.name}</Tag>
            })}

            {includeOther && (
                <Tag key={"Other"}
                     slug={"other"}
                     isActive={otherSelected}
                     onToggle={toggleSelected}>
                    {otherSelected
                        ? (<>+ Other: <TextInput ref={otherValueRef}
                                                 className="bg-teal border-0 border-b-2 border-white focus:ring-transparent focus:border-white p-1 outline-none"
                                                 type={"text"} value={otherValue}
                                                 onClick={(e) => e.stopPropagation()}
                                                 onChange={changeOtherValue}/></>)
                        : (<>+ Other</>)
                    }
                </Tag>
            )}
        </div>
    );

}
