import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function CleanLayout({ children }: PropsWithChildren) {
    return (

        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <div className="w-full sm:max-w-lg mt-6 px-6 py-4 overflow-hidden">
                {children}
            </div>
        </div>
    );
}
