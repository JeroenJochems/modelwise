export default function LogoCloud() {
    return (
        <div className="bg-white py-24 sm:py-32">
            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                <div className="grid grid-cols-1 items-center gap-x-8 gap-y-16 lg:grid-cols-2">
                    <div className="mx-auto w-full max-w-xl lg:mx-0">
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900">Trusted by amazing brands</h2>
                    </div>
                    <div className="mx-auto grid w-full max-w-xl grid-cols-2 items-center gap-y-12 sm:gap-y-14 lg:mx-0 lg:max-w-none lg:pl-8">
                        <img
                            className="max-h-12 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/expedia-2.png?fm=auto&w=212"
                            alt="Expedia"
                            width={105}
                        />
                        <img
                            className="max-h-12 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/hotels-2.png?fm=auto&w=212"
                            alt="Hotels"
                            width={105}
                        />
                        <img
                            className="max-h-12 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/garmin-2.png?fm=auto&w=212"
                            alt="Garmin"
                            width={105}
                        />
                        <img
                            className="max-h-24 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/socialclub.png?fm=auto&w=212"
                            alt="Social club"
                            width={210}
                        />
                        <img
                            className="max-h-24 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/mcdonalds.png?fm=auto&w=212"
                            alt="McDonalds"
                            width={210}
                        />
                        <img
                            className="max-h-24 w-full object-contain object-left"
                            src="https://modelwise.imgix.net/assets/nike.webp?fm=auto&w=212"
                            alt="Nike"
                            width={210}
                        />
                    </div>
                </div>
            </div>
        </div>
    )
}
