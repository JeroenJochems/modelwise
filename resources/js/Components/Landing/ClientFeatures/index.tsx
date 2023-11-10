import { ArrowPathIcon, CloudArrowUpIcon } from '@heroicons/react/20/solid'
import {CloudIcon, HeartIcon, UsersIcon} from "@heroicons/react/24/solid";

const features = [
    {
        name: 'No sneaky markups',
        description:
            'We charge a flat 20% agency fee, both on bookings and buyouts. No hidden fees. No commission for models.',
        icon: CloudIcon ,
    },
    {
        name: 'No stress buyouts™️',
        description:
            'Buyouts at Modelwise are simple: country + duration. No more stress about usage and distribution channels.',
        icon: HeartIcon ,
    },
    {
        name: 'Efficient booking process',
        description:
            'We\'ll handle all aspects of the booking process. Fast and efficient.',
        icon: ArrowPathIcon,
    },
    {
        name: 'Top-notch actors & models',
        description:
            '0% commission for models means we\'ll have access to the best freelance models in the world. That\'s going to be an amazing shoot.',
        icon: UsersIcon,
    },
]

export default function ClientFeatures() {
    return (
        <div className="bg-white py-24 sm:py-32">
            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                <div className="mx-auto max-w-2xl lg:text-center">
                    <h2 className="text-base font-semibold leading-7 text-teal">How we help clients</h2>
                    <p className="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Efficient. Transparent. Honest.
                    </p>
                    <p className="mt-6 text-lg leading-8 text-gray-600">
                        The modeling industry is rife with questionable practices, and our aim is to bring about positive change.
                    </p>
                </div>
                <div className="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl className="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-2">
                        {features.map((feature) => (
                            <div key={feature.name} className="flex flex-col">
                                <dt className="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                    <feature.icon className="h-5 w-5 flex-none text-teal" aria-hidden="true" />
                                    {feature.name}
                                </dt>
                                <dd className="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                    <p className="flex-auto">{feature.description}</p>
                                </dd>
                            </div>
                        ))}
                    </dl>
                </div>
            </div>
        </div>
    )
}
