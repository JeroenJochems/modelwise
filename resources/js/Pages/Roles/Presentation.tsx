import PresentationListing from "@/Components/Organisms/ProposalModel";
import {H2} from "@/Components/Typography/H2";
import {useState} from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import {router} from '@inertiajs/react'
import {ListingData, PresentationData} from "@/types/generated";

type Props =  {
    presentation: PresentationData
    listings: ListingData[]
}

export default function Show({ presentation, listings}: Props)
{
    const initialSelection = listings.filter(a => a.favorited_at);
    const [selected, setSelected] = useState<ListingData[]>(initialSelection);

    const handleSelect = (listing: ListingData) => {
        setSelected((prev) => {
            if (prev.includes(listing)) {
                return prev.filter((app) => app !== listing);
            }

            return [...prev, listing];
        })
    }

    function concat(listings: ListingData[]) {
        const names = listings.map(listing => listing.model.first_name);

        if (names.length === 0) return 'no models'
        if (names.length === 1) return names[0];
        if (names.length === 2) return names.join(" and ");
        if (names.length < 6) return names.slice(0, -1).join(", ") + ", and " + names.slice(-1);

        return names.length + " models";
    }

    function handleSubmit() {
        router.post(`/presentations/${presentation.id}/favorite`, { favoriteListings: selected.map(listing => listing.id) });
    }

    const hasSelectionChanged = selected.map(a=>a.id).sort().join('-') !== initialSelection.map(b=>b.id).sort().join('-')

    return (
        <div className={"flex h-screen-safe flex-col overflow-hidden relative"}>
            <div className="overflow-scroll flex-grow mt-8 px-4 py-12 sm:px-6 lg:px-8">

                <div className={"mx-auto max-w-2xl  lg:max-w-7xl"}>
                    <h1 className={"font-bold text-2xl sm:text-4xl mt-4"}>Proposal</h1>
                    <H2>{presentation.role.name} {presentation.role.job.title}</H2>

                    <div className={"flex flex-col gap-8 mt-16"}>
                        {listings.map(listing => <PresentationListing
                            presentation={presentation}
                            listing={listing}
                            onSelect={handleSelect}
                            isSelected={selected.some(app => app.id === listing.id)}
                            key={listing.id}
                        />)}
                    </div>
                </div>
            </div>

            <div className={"p-4"}>
                <div className={"mx-auto max-w-2xl  lg:max-w-7xl"}>
                    { hasSelectionChanged && (
                        <PrimaryButton onClick={handleSubmit} className={"w-full"}>
                            Favorite {concat(selected)}
                        </PrimaryButton>
                    )}
                </div>
            </div>
        </div>
    )
}
