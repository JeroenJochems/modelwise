import {HTMLAttributes} from "react";

export function DashboardFooter({ children='', className}: HTMLAttributes<HTMLDivElement> ) {

    return (
        <div className={`${className} relative mx-auto max-w-7xl justify-center p-4`}>
            { children }
        </div>
    );
}
