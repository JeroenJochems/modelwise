import { PropsWithChildren } from 'react';
import Menu from "@/Components/Menu/Menu";
import {usePage} from "@inertiajs/react";

type Props = {
    header?: React.ReactNode
    footer?: React.ReactNode
    footerClasses?: string
} & PropsWithChildren

export default function DashboardLayout({ children, header, footer, footerClasses  }: Props) {

    return (
        <div className={"flex h-screen flex-col overflow-hidden"}>
            <div className={"overflow-scroll flex-grow"}>
                <div className={"relative"}>
                    <Menu />
                </div>
                <div className="relative justify-center p-4 mx-auto max-w-6xl py-4">
                    { children }
                </div>
            </div>
            <div>
                { footer }
            </div>
        </div>
    )
}
