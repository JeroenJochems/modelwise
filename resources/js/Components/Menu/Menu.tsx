import { useState } from 'react'
import { Dialog } from '@headlessui/react'
import {ArrowLeftOnRectangleIcon, ArrowRightOnRectangleIcon, Bars3Icon, XMarkIcon} from '@heroicons/react/24/outline'
import {asset} from "laravel-vapor";
import {Link, usePage} from "@inertiajs/react";
import {PageProps} from "@/types";

const navigation = [
    { name: 'Dashboard', href: '/dashboard' },
    { name: 'Profile', href: '/account' },
]


export default function Menu() {
    const { auth } = usePage<PageProps>().props;

    const isLoggedIn = !!auth.user;

    const [mobileMenuOpen, setMobileMenuOpen] = useState(false)

    return (
        <header className={""}>
            <nav className="mx-auto flex max-w-7xl items-center justify-between p-4" aria-label="Global">
                <div className="flex flex-1">
                    { isLoggedIn && (
                        <>
                            <div className="hidden lg:flex lg:gap-x-12">
                                {navigation.map((item) => (
                                    <a key={item.name} href={item.href} className="text-sm font-semibold leading-6 text-black">
                                        {item.name}
                                    </a>
                                ))}
                            </div>
                            <div className="flex lg:hidden">
                                <button
                                    type="button"
                                    className="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                                    onClick={() => setMobileMenuOpen(true)}>
                                    <span className="sr-only">Open main menu</span>
                                    <Bars3Icon className="h-6 w-6" aria-hidden="true" />
                                </button>
                            </div>
                        </>
                    )}
                </div>
                <a href="#" className="-m-1.5 p-1.5">
                    <span className="sr-only">Modelwise</span>
                    <img className="h-8 w-auto" src={asset("img/logo-black.svg")} alt="Modelwise" />
                </a>
                <div className="flex flex-1 justify-end">
                    { isLoggedIn ? (
                        <Link href={route("logout")} method="post" as="button" type="button">
                            Log out
                        </Link>
                    ) : (
                        <Link href={route("login")} type="button">
                            Log in
                        </Link>
                    )}
                </div>
            </nav>

            <Dialog as="div" className="lg:hidden" open={mobileMenuOpen} onClose={setMobileMenuOpen}>
                <div className="fixed inset-0 z-10" />
                <Dialog.Panel className="fixed inset-y-0 left-0 z-10 w-full overflow-y-auto bg-white p-4">
                    <div className="flex items-center justify-between">
                        <div className="flex flex-1">
                            <button
                                type="button"
                                className="-m-2.5 rounded-md p-2.5 text-gray-700"
                                onClick={() => setMobileMenuOpen(false)}
                            >
                                <span className="sr-only">Close menu</span>
                                <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <a href="#" className="-m-1.5 p-1.5">
                            <span className="sr-only">Modelwise</span>
                            <img className="h-8 w-auto" src={asset("img/logo-black.svg")} alt="" />
                        </a>
                        <div className="flex flex-1 justify-end">
                        </div>
                    </div>
                    <div className="mt-6 space-y-2">
                        {navigation.map((item) => (
                            <a
                                key={item.name}
                                href={item.href}
                                className="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                            >
                                {item.name}
                            </a>
                        ))}
                        { }

                        <Link href={route("logout")} method="post" as="button" type="button"  className="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                            Log out
                        </Link>
                    </div>
                </Dialog.Panel>
            </Dialog>
        </header>
    )
}
