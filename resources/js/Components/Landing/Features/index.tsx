import { CloudArrowUpIcon, LockClosedIcon, ServerIcon } from '@heroicons/react/20/solid'

const features = [
    {
        name: '0% commission or hidden fees',
        description:
            'Unlike traditional model agencies we don\'t charge both the model and the client. We only charge the client a 20% fee. Makes sense, right?',
        icon: CloudArrowUpIcon,
    },
    {
        name: 'Closed platform with full privacy',
        description: 'Only you decide who can see your profile.',
        icon: LockClosedIcon,
    },
    {
        name: 'Efficient booking process',
        description: 'No unnecessary casting videos, no unnecessary emails. Just efficient bookings.',
        icon: ServerIcon,
    },
]

export default function Features() {
    return (
        <div className="overflow-hidden bg-white sm:pt-4 pb-16 sm:py-24">
            <div className="mx-auto max-w-7xl md:px-6 lg:px-8">
                <div className="grid grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:grid-cols-2 lg:items-start">
                    <div className="px-6 lg:px-0 lg:pr-4 lg:pt-4">
                        <div className="mx-auto max-w-2xl lg:mx-0 lg:max-w-lg">
                            <h2 className="text-base font-semibold leading-7 text-teal">How we help models and actors</h2>
                            <p className="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Efficient. Transparent. Honest.</p>
                            <p className="mt-6 text-lg leading-8 text-gray-600">
                                Let's redefine the standard in model booking. Together.
                            </p>
                            <dl className="mt-10 max-w-xl space-y-8 text-base leading-7 text-gray-600 lg:max-w-none">
                                {features.map((feature) => (
                                    <div key={feature.name} className="relative pl-9">
                                        <dt className="inline font-semibold text-gray-900">
                                            <feature.icon className="absolute left-1 top-1 h-5 w-5 text-teal" aria-hidden="true" />
                                            {feature.name}
                                        </dt>{' '}
                                        <dd className="inline">{feature.description}</dd>
                                    </div>
                                ))}
                            </dl>
                        </div>
                    </div>
                    <div className="sm:px-6 lg:px-0">
                        <div className="relative isolate overflow-hidden bg-teal px-6 pt-8 sm:mx-auto sm:max-w-2xl sm:rounded-3xl sm:pl-16 sm:pr-0 sm:pt-16 lg:mx-0 lg:max-w-none">

                            <div className="mx-auto max-w-2xl sm:mx-0 sm:max-w-none">
                                <img
                                    src="https://modelwise.imgix.net/photos/2bc5358f-d3b4-4eb3-a1e0-bd586faa9866?fm=auto&w=2400&h=1442&q=80"
                                    alt="Product screenshot"
                                    width={2432}
                                    height={1442}
                                    className="-mb-12 w-full max-w-none rounded-tl-xl bg-gray-800 ring-1 ring-white/10"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
