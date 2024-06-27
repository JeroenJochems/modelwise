import MuxPlayer from "@mux/mux-player-react";
import "@mux/mux-player/themes/minimal";
import {TwicPicture} from "@twicpics/components/react";
import {CheckCircleIcon} from "@heroicons/react/24/solid/index.js";
import {ListingData, ModelPhotoData, PhotoData, PresentationData} from "@/types/generated";
import {PlusIcon} from "@heroicons/react/24/solid";

type Props = {
    presentation: PresentationData,
    listing: ListingData,
    onSelect: (listing: ListingData) => void,
    isSelected: boolean
}

function uniquePhotos(photos: Array<PhotoData|ModelPhotoData>) {
    const copy = [...photos];
    return photos.filter(
        (v) => v.hash === null || copy.filter((cp) => cp.hash === v.hash).length === 1
    );
}

export default function PresentationListing({ presentation, listing, onSelect, isSelected }: Props) {

    const photos = [
        ...listing.photos,
        ...listing.casting_photos,
        ...listing.model.portfolio!.slice(0, 8)
    ];

    if (listing.model.profile_picture && listing.model.id) {
        photos.unshift({ id: listing.model.id, path: listing.model.profile_picture, mime: "image/jpeg", hash: null });
    }

    return (
        <div className={`pt-12 break-inside-avoid-page grid gap-4 border-2 rounded p-8 ${isSelected ? 'border-green' : 'border-white'}`}>
            <div className={"w-full"}>
                <div>
                    <h1 className="flex items-center mb-4 text-3xl font-medium text-gray-900">
                        <label htmlFor={`shortlist${listing.id}`}
                               className="flex flex-grow items-center cursor-pointer font-medium text-gray-900">
                            {listing.model.first_name}


                        </label>
                        <div className="flex h-6 items-center">
                            <label onClick={() => onSelect(listing)} htmlFor={`#shortlist${listing.id}`}
                                className={`ml-2 inline-flex gap-2 items-center rounded-md ${isSelected ? 'bg-green text-white' : 'bg-white text-green'} border border-green px-2 py-1 text-base`}>
                                { isSelected ? <CheckCircleIcon className={"w-4 h-4"}/> : <PlusIcon className={"w-4 h-4"}/> }
                                Favorite
                            </label>

                            {!!listing.shortlisted_at && (
                                <span
                                    className="ml-2 inline-flex items-center rounded-md bg-green px-2 py-1 text-xs font-medium text-white">
                                    <CheckCircleIcon className={"w-4 h-4"}/> Favorite
                                </span>
                            )}
                        </div>
                    </h1>

                    {presentation.should_show_cover_letter && !!listing.cover_letter &&
                        <div className="mb-4 prose prose-sm">{listing.cover_letter}</div>}
                    {!!listing.casting_questions && (
                        <div className="mb-4 prose prose-sm">
                            <strong>{presentation.role.casting_questions}</strong><br/>
                            {listing.casting_questions}
                        </div>
                    )}
                    {presentation.should_show_conflicts && !!listing.brand_conflicted &&
                        <div className="mb-4 prose prose-sm">
                            <div className={"font-semibold"}>Brand conflicts</div>
                            {listing.brand_conflicted}
                        </div>}
                </div>
                <div className={"col-span-1 w-full grid grid-cols-2 sm:grid-cols-3 gap-4"}>
                    {presentation.should_show_socials && !!listing.model.instagram &&
                        <div>
                            <div className={"font-semibold"}>
                                Instragram
                            </div>
                            <div className={"mb-4"}>
                                <a className={"underline"}
                                   href={`https://www.instagram.com/${listing.model.instagram}`} target="_blank">
                                    {listing.model.instagram}
                                </a>
                            </div>
                        </div>
                    }
                    {presentation.should_show_socials && !!listing.model.website &&
                        <div>
                            <div className={"font-semibold"}>
                                Website
                            </div>
                            <div className={"mb-4"}>
                                <a target={"_blank"} href={listing.model.website} className={"underline"}>Open in
                                    new tab</a>
                            </div>
                        </div>
                    }
                    {presentation.should_show_socials && !!listing.model.tiktok &&
                        <div>
                            <div className={"font-semibold"}>
                                Website
                            </div>
                            <div className={"mb-4"}>
                                {listing.model.tiktok}
                            </div>
                        </div>
                    }
                    <div>
                        <div className={"font-semibold"}>
                            Height
                        </div>
                        <div className={"mb-4"}>
                            {listing.model.height && listing.model.height > 10 ? Math.round(listing.model.height) : "unknown"}
                        </div>
                    </div>
                    <div>
                        <div className={"font-semibold"}>
                            Waist
                        </div>
                        <div className={"mb-4"}>
                            {listing.model.waist && listing.model.waist > 10 ? Math.round(listing.model.waist) : "unknown"}
                        </div>
                    </div>
                    <div>
                        <div className={"font-semibold"}>
                            Hips
                        </div>
                        <div className={"mb-4"}>
                            {listing.model.hips && listing.model.hips > 10 ? Math.round(listing.model.hips) : "unknown"}
                        </div>
                    </div>
                    {!!listing.model.hair_color &&
                        <div>
                            <div className={"font-semibold"}>
                                Hair color
                            </div>
                            <div className={"mb-4"}>
                                {listing.model.hair_color}
                            </div>
                        </div>
                    }

                    {!!listing.model.eye_color &&
                        <div>
                            <div className={"font-semibold"}>
                                Eye color
                            </div>
                            <div className={"mb-4"}>
                                {listing.model.eye_color == "Other" ? listing.model.eye_color_other : listing.model.eye_color}
                            </div>
                        </div>
                    }
                    {!!listing.model.clothing_size_top &&
                        <div>
                            <div className={"font-semibold"}>
                                Clothing size
                            </div>
                            <div className={"mb-4"}>
                                {listing.model.clothing_size_top}
                            </div>
                        </div>
                    }

                    <div>
                        <div className={"font-semibold"}>
                            Shoe size
                        </div>
                        <div className={"mb-4"}>
                            {listing.model.shoe_size && listing.model.shoe_size > 10 ? Math.round(listing.model.shoe_size) : "unknown"}
                        </div>
                    </div>
                    {listing.model.cup_size && <div>
                        <div className={"font-semibold"}>
                            Cup size
                        </div>
                        <div className={"mb-4"}>
                            {listing.model.cup_size}
                        </div>
                    </div>
                    }
                </div>
            </div>
            <div className={"mt-4 grid grid-cols-1 lg:grid-cols-4 gap-4"}>

                {presentation.should_show_casting_media && listing.casting_videos.map((video) => (
                    <div key={video.mux_id} className={"aspect-square rounded-lg overflow-hidden"}>
                        <MuxPlayer theme="minimal" poster="/img/poster-casting-video.png" playbackId={video.mux_id ?? ""}
                                   className={"object-fit aspect-square rounded-lg"}/>
                    </div>
                ))}

                {uniquePhotos(photos).slice(0, 8).map((photo) => (
                    <div className={"flex rounded-lg overflow-hidden"} key={photo.id}>
                        <TwicPicture
                            src={photo.path}
                            ratio="1:1"
                            focus="auto"
                        />
                    </div>
                ))}
            </div>

            {presentation.should_show_digitals && !!listing.model.digitals && (
                <div className={`grid grid-cols-2 lg:grid-cols-${listing.model.digitals.slice(0, 8).length} gap-4`}>
                    {uniquePhotos(listing.model.digitals).slice(0, 8).map((photo) => (
                        <div key={photo.id} className={"flex rounded-lg overflow-hidden"}>
                            <TwicPicture
                                src={photo.path}
                                ratio="1:1"
                                focus="auto"
                            />
                        </div>
                    ))}
                </div>
            )}

        </div>
    )
}
