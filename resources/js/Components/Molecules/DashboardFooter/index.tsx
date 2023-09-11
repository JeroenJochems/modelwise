import {HTMLAttributes} from "react";

export function DashboardFooter({ children, className}: HTMLAttributes<HTMLDivElement> ) {

    return (
        <div className={`${className} relative justify-center p-4`}>
            <div className={"mx-auto max-w-6xl"}>
                { children }
            </div>
        </div>
    );
}
