import {PropsWithChildren} from "react";
import {getRoleLabel} from "@/Utils/RoleLabel";

export function Label({ children }: PropsWithChildren) {
    return (
        <div>
            <span className={"w-auto bg-black text-white px-2 py-1 rounded"}>
                {children}
            </span>
        </div>
    )
}
