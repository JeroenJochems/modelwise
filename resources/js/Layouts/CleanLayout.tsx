import {PropsWithChildren, ReactNode} from 'react';
import PrimaryButton from "@/Components/PrimaryButton";

type Props = PropsWithChildren & {
    photos?: Array<string>;
    header?: ReactNode;
    mobileSplit?: boolean;
}

export default function CleanLayout({
                                        children,
                                        mobileSplit,
                                        header = null,
                                        photos = ['https://modelwise.imgix.net/photos/d065b15e-5b88-49bf-aae2-009f141fc30f?exp=-20']
                                    }: Props) {

    return (
        <div className="flex min-h-full h-full flex-row-reverse">
            <>
                <div className="flex flex-col w-full min-h-full lg:w-full">
                    <div className="mx-auto min-h-full flex flex-col w-full max-w-2xl">

                        { mobileSplit && (
                            <div className={"w-full aspect-[4/3] text-white p-4 sm:hidden"} style={{backgroundImage: `url(${photos[0]})`, backgroundSize: 'cover'}}>
                                {header}
                            </div>
                        )}

                        <div className={`${ mobileSplit ? 'hidden' : '' } w-full p-4 sm:flex`}>
                            {header}
                        </div>

                        <div className="p-4 flex-grow overflow-y-scroll">
                            {children}
                        </div>

                        <div>
                            <PrimaryButton>test
                            </PrimaryButton>
                        </div>
                    </div>
                </div>

                <div className="hidden lg:block w-1/2 h-full">
                    <div className="h-full bg-cover bg-center" style={{backgroundImage: `url(${photos[0]})`}}></div>
                </div>
            </>

        </div>
    )
}
