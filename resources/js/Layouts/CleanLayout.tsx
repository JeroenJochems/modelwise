import {PropsWithChildren, ReactNode} from 'react';

type Props = PropsWithChildren & {
    photos?: Array<string>;
    header?: ReactNode;
}

export default function CleanLayout({ children, header=null, photos = ['https://modelwise.imgix.net/photos/d065b15e-5b88-49bf-aae2-009f141fc30f'] }: Props) {

    return (
        <div className="flex min-h-full h-full flex-row-reverse">


            <div className="flex flex-col w-full min-h-full overflow-x-scroll lg:w-full">
                {header}
                <div className="mx-auto w-full max-w-2xl py-8 grid gap-4">
                    { children }
                </div>
            </div>

        </div>
    )
}
