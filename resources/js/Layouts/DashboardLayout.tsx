import { PropsWithChildren } from 'react';
import {asset} from "laravel-vapor";

type Props = PropsWithChildren & {
    photo?: string;
}

export default function DashboardLayout({ children }: PropsWithChildren) {

    return (
        <div className="justify-center">
            { children }
        </div>
    )
}
