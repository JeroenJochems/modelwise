import { useState } from 'react'
import { Dialog } from '@headlessui/react'
import { XMarkIcon } from '@heroicons/react/24/outline'
import {asset} from "laravel-vapor";
import {Link} from "@inertiajs/react";
import { useParallax } from 'react-scroll-parallax';

const navigation = [
    { name: 'How it works', href: '#' },
]

export default function Hero() {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
    const { ref: ref1 } = useParallax<HTMLDivElement>({speed: 15});
    const { ref: ref2 } = useParallax<HTMLDivElement>({speed: 30});
    const { ref: ref3 } = useParallax<HTMLDivElement>({speed: 10});
    const { ref: ref4 } = useParallax<HTMLDivElement>({speed: -20});

    return (
        <div className="bg-white">
            <header className="absolute inset-x-0 top-0 z-50">
                <nav className="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
                    <div className="flex lg:flex-1">
                        <Link href={route("landing")} className="-m-1.5 p-1.5">
                            <span className="sr-only">Modelwise</span>
                            <img className="h-8 w-auto" src={asset("img/logo-black.svg")} alt="Modelwise" />
                        </Link>
                    </div>
                    <div className="flex lg:hidden">

                    </div>
                    <div className="hidden lg:flex lg:gap-x-12">

                    </div>
                    <div className="hidden lg:flex lg:flex-1 lg:justify-end">
                        <Link href={route("login")} className="text-sm font-semibold leading-6 text-gray-900">
                            Log in <span aria-hidden="true">&rarr;</span>
                        </Link>
                    </div>
                </nav>
                <Dialog as="div" className="lg:hidden" open={mobileMenuOpen} onClose={setMobileMenuOpen}>
                    <div className="fixed inset-0 z-50" />
                    <Dialog.Panel className="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                        <div className="flex items-center justify-between">
                            <a href="#" className="-m-1.5 p-1.5">
                                <span className="sr-only">Modelwise</span>
                                <img
                                    className="h-8 w-auto"
                                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                    alt=""
                                />
                            </a>
                            <button
                                type="button"
                                className="-m-2.5 rounded-md p-2.5 text-gray-700"
                                onClick={() => setMobileMenuOpen(false)}
                            >
                                <span className="sr-only">Close menu</span>
                                <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <div className="mt-6 flow-root">
                            <div className="-my-6 divide-y divide-gray-500/10">
                                <div className="space-y-2 py-6">
                                    {navigation.map((item) => (
                                        <Link
                                            key={item.name}
                                            href={item.href}
                                            className="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                                        >
                                            {item.name}
                                        </Link>
                                    ))}
                                </div>
                                <div className="py-6">
                                    <a
                                        href={route("login")}
                                        className="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                                    >
                                        Log in
                                    </a>
                                </div>
                            </div>
                        </div>
                    </Dialog.Panel>
                </Dialog>
            </header>
            <main>
                <div className="relative isolate">
                    <div
                        className="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48"
                        aria-hidden="true"
                    >
                        <div
                            className="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                            style={{
                                clipPath:
                                    'polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)',
                            }}
                        />
                    </div>
                    <div className="overflow-hidden">
                        <div className="mx-auto max-w-7xl px-6 pb-16 sm:pb-48 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
                            <div className="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                                <div className="w-full max-w-xl lg:shrink-0 pb-24 xl:max-w-2xl">
                                    <h1 className="text-4xl pt-12 font-bold tracking-tight text-gray-900 sm:text-6xl">
                                        Talent bookings<br />done right.
                                    </h1>
                                    <p className="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">
                                        20% flat agency fee on bookings and buyouts.<br />
                                        No hidden fees.<br />
                                        No commission for models.<br />
                                        Top-notch actors & models
                                        <br />
                                    </p>
                                    <div className="mt-10 flex flex-col sm:flex-row items-left">
                                        <div className={"mb-6"}>
                                            <Link
                                                href={route("login")}
                                                className="rounded-md bg-teal px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            >
                                                Sign up as actor / model
                                            </Link>

                                        </div>
                                        <Link href="#contact" className="text-sm font-semibold sm:ml-6 leading-6 text-gray-900">
                                            Client contact <span aria-hidden="true">→</span>
                                        </Link>
                                    </div>
                                </div>

                                <div className={"grid gap-8 grid-cols-2"}>
                                    <div ref={ref1}>
                                        <img
                                            src="https://modelwise.imgix.net/assets/2.5.jpeg?fm=auto&h=528"
                                            alt=""
                                            className="aspect-[2/3] mb-8 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                        />
                                        <img
                                            src="https://modelwise.imgix.net/assets/15.jpeg?fm=auto&h=528"
                                            alt=""
                                            className="aspect-[2/3] mb-8 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                        />
                                    </div>
                                    <div ref={ref2}>
                                        <img
                                            src="https://modelwise.imgix.net/assets/a3.jpg?fm=auto&h=528"
                                            alt=""
                                            className="aspect-[2/3] mb-8 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                        />
                                        <img
                                            src="https://modelwise.imgix.net/assets/a1.jpg?fm=auto&h=528"
                                            alt=""
                                            className="aspect-[2/3] mb-8 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                        />
                                    </div>

                                </div>

                                <div className="hidden sm:flex mt-14 justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
                                    <div className="ml-auto w-44 flex-none space-y-8 pt-32 sm:ml-0 sm:pt-80 lg:order-last lg:pt-36 xl:order-none xl:pt-80">
                                        <div className="relative">
                                            <img
                                                src="https://modelwise.imgix.net/assets/2.5.jpeg?fm=auto&h=528"
                                                alt=""
                                                className="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                            />
                                            <div className="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10" />
                                        </div>
                                    </div>
                                    <div ref={ref3} className="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-64 lg:pt-36">
                                        <div className="relative">
                                            <img
                                                src="https://modelwise.imgix.net/assets/15.jpeg?fm=auto&h=528"
                                                alt=""
                                                className="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                            />
                                            <div className="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10" />
                                        </div>
                                        <div className="relative">
                                            <img
                                                src="https://modelwise.imgix.net/assets/a3.jpg?fm=auto&h=528"
                                                alt=""
                                                className="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                            />
                                            <div className="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10" />
                                        </div>
                                    </div>
                                    <div ref={ref4} className="w-44 flex-none space-y-8 pt-32 sm:pt-0">
                                        <div className="relative">
                                            <img
                                                src="https://modelwise.imgix.net/assets/a1.jpg?fm=auto&h=528"
                                                alt=""
                                                className="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                            />
                                            <div className="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10" />
                                        </div>
                                        <div className="relative">
                                            <img
                                                src="https://modelwise.imgix.net/assets/5.jpeg?h=528"
                                                alt=""
                                                className="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                                            />
                                            <div className="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    )
}
