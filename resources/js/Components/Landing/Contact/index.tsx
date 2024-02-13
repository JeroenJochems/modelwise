/*
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
*/
import {useForm} from "@inertiajs/react";
import {useState} from "react";

export default function Contact({ successMessage}: { successMessage?: string }) {

    const [submitted, setSubmitted] = useState(false);

    const { post, setData, errors } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
    });

    const submit = () => {
        post(route("contact"), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setSubmitted(true);
            }
        });
    }




    return (
        <div id="contact" className="relative bg-white">
            <div className="lg:absolute lg:inset-0 lg:left-1/2">
                <img
                    className="h-64 w-full bg-gray-50 object-cover sm:h-80 lg:absolute lg:h-full"
                    src="https://modelwise.imgix.net/assets/3.jpeg?auto=format&fit=max&w=2432"
                    alt=""
                />
            </div>
            <div className="pb-24 pt-16 sm:pb-32 sm:pt-24 lg:mx-auto lg:grid lg:max-w-7xl lg:grid-cols-2 lg:pt-32">
                <div className="px-6 lg:px-8">
                    <div className="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900">Let's work together</h2>
                        <p className="mt-2 text-lg leading-8 text-gray-600">
                            Contact us to receive a matching proposal within 48 hours.
                        </p>
                        <p className="mt-4 text-lg leading-8 text-gray-600">
                            Are you a model or actor? Use the <a href="/about-modelwise" className={"underline"}>registration form instead</a>.
                        </p>
                        <form method="POST" className="mt-8">
                            <div className="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label htmlFor="first-name" className="block text-sm font-semibold leading-6 text-gray-900">
                                        First name
                                    </label>
                                    <div className="mt-2.5">
                                        <input
                                            type="text"
                                            name="first-name"
                                            id="first-name"
                                            onChange={e => setData('first_name', e.target.value)}
                                            autoComplete="given-name"
                                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal sm:text-sm sm:leading-6"
                                        />

                                        <div className={"mt-2 text-sm text-red-600"}>
                                            {errors.first_name}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label htmlFor="last-name" className="block text-sm font-semibold leading-6 text-gray-900">
                                        Last name
                                    </label>
                                    <div className="mt-2.5">
                                        <input
                                            type="text"
                                            name="last-name"
                                            id="last-name"
                                            onChange={e => setData('last_name', e.target.value)}
                                            autoComplete="family-name"
                                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal sm:text-sm sm:leading-6"
                                        />
                                        <div className={"mt-2 text-sm text-red-600"}>
                                            {errors.last_name}
                                        </div>
                                    </div>
                                </div>
                                <div className="sm:col-span-2">
                                    <label htmlFor="email" className="block text-sm font-semibold leading-6 text-gray-900">
                                        Email
                                    </label>
                                    <div className="mt-2.5">
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            onChange={e => setData('email', e.target.value)}
                                            autoComplete="email"
                                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal sm:text-sm sm:leading-6"
                                        />
                                        <div className={"mt-2 text-sm text-red-600"}>
                                            {errors.email}
                                        </div>
                                    </div>

                                </div>
                                <div className="sm:col-span-2">
                                <div className="flex justify-between text-sm leading-6">
                                        <label htmlFor="phone" className="block font-semibold text-gray-900">
                                            Phone
                                        </label>
                                    </div>
                                    <div className="mt-2.5">
                                        <input
                                            type="tel"
                                            name="phone"
                                            id="phone"
                                            onChange={e => setData('phone', e.target.value)}
                                            autoComplete="tel"
                                            aria-describedby="phone-description"
                                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal sm:text-sm sm:leading-6"
                                        />
                                        <div className={"mt-2 text-sm text-red-600"}>
                                            {errors.phone}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {submitted && (
                                <div className={"mt-4 text-sm text-green-600"}>
                                    Thank you for your message. We will get back to you within 48 hours.
                                </div>
                            )}

                            <div className="mt-10 flex justify-end pt-8">
                                <button
                                    onClick={function(e) { e.preventDefault(); submit() }}
                                    type="submit"
                                    className="rounded-md bg-teal px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-teal-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Send message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    )
}
