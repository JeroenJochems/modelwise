import { PropsWithChildren } from 'react';
import Menu from "@/Components/Menu/Menu";
import {flare} from "@flareapp/js";

type Props = {
    header?: React.ReactNode
    footer?: React.ReactNode
    footerClasses?: string
} & PropsWithChildren

export default function DashboardLayout({ children, header, footer, footerClasses  }: Props) {

    return (
        <div className={"flex h-screen-safe flex-col overflow-hidden relative"}>
            {/*<img src="https://tailwindui.com/img/beams-home@95.jpg" alt="" className="absolute -top-[1rem] left-1/2 -ml-[40rem] w-[163.125rem] max-w-none sm:-ml-[67.5rem]" />*/}

            <div className={"overflow-scroll flex-grow"}>
                <div className={"relative"}>
                    <Menu />
                </div>
                <div className="relative justify-center p-4 mx-auto max-w-7xl py-4">
                    { children }
                </div>
            </div>
            <div>
                { footer }
            </div>
        </div>
    )
}
