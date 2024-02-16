import {usePage} from "@inertiajs/react";
import MuxPlayer from "@mux/mux-player-react";
import "@mux/mux-player/themes/minimal";

export default function ProposalModel({ presentation, application}) {
    const {cdn_url} = usePage().props;

    let photos = application.photos ;

    if (presentation.should_show_casting_media) {
        photos = [...application.casting_photos, ...photos];
    }

    if (photos.length < 1) {
        photos = [...application.model.photos.slice(8)]
    }

    return (
        <div className={"pt-12 break-inside-avoid-page grid gap-4"}>

            <div className={"w-ful"}>
                <div>
                    <h1 className="sm:w-1/2 text-3xl font-medium text-gray-900">{application.model.first_name}</h1>
                    { presentation.should_show_cover_letter && application.cover_letter && <div className="mb-4 prose prose-sm">{ application.cover_letter }</div> }
                    { presentation.should_show_conflicts && application.brand_conflicted && <div className="mb-4 prose prose-sm">
                        <div className={"font-semibold"}>Brand conflicts</div>
                        { application.brand_conflicted }
                    </div> }
                </div>
                <div className={"col-span-1 w-full grid grid-cols-2 sm:grid-cols-3 gap-4"}>
                    { presentation.should_show_socials && application.model.instagram &&
                        <div>
                            <div className={"font-semibold"}>
                                Instragram
                            </div>
                            <div className={"mb-4"}>
                                <a className={"underline"} href={`https://www.instagram.com/${application.model.instagram}`} target="_blank">
                                    { application.model.instagram }
                                </a>
                            </div>
                        </div>
                    }
                    { presentation.should_show_socials && application.model.website &&
                        <div>
                            <div className={"font-semibold"}>
                                Website
                            </div>
                            <div className={"mb-4"}>
                                <a target={"_blank"} href={application.model.website} className={"underline"}>Open in new tab</a>
                            </div>
                        </div>
                    }
                    { presentation.should_show_socials && application.model.tiktok &&
                        <div>
                            <div className={"font-semibold"}>
                                Website
                            </div>
                            <div className={"mb-4"}>
                                { application.model.tiktok }
                            </div>
                        </div>
                    }
                    <div>
                        <div className={"font-semibold"}>
                            Height
                        </div>
                        <div className={"mb-4"}>
                            { Math.round(application.model.height) }
                        </div>
                    </div>
                    <div>
                        <div className={"font-semibold"}>
                            Waist
                        </div>
                        <div className={"mb-4"}>
                            { Math.round(application.model.waist) }
                        </div>
                    </div>
                    <div>
                        <div className={"font-semibold"}>
                            Hips
                        </div>
                        <div className={"mb-4"}>
                            { Math.round(application.model.hips) }
                        </div>
                    </div>
                    { application.model.hair_color &&
                        <div>
                            <div className={"font-semibold"}>
                                Hair color
                            </div>
                            <div className={"mb-4"}>
                                { application.model.hair_color }
                            </div>
                        </div>
                    }

                    { application.model.eye_color &&
                        <div>
                            <div className={"font-semibold"}>
                                Eye color
                            </div>
                            <div className={"mb-4"}>
                                { application.model.eye_color == "Other" ? application.model.eye_color_other : application.model.eye_color }
                            </div>
                        </div>
                    }
                    { application.model.clothing_size_top &&
                        <div>
                            <div className={"font-semibold"}>
                                Clothing size
                            </div>
                            <div className={"mb-4"}>
                                { application.model.clothing_size_top }
                            </div>
                        </div>
                    }

                    <div>
                        <div className={"font-semibold"}>
                            Shoe size
                        </div>
                        <div className={"mb-4"}>
                            { Math.round(application.model.shoe_size) }
                        </div>
                    </div>
                    { application.model.cup_size && <div>
                        <div className={"font-semibold"}>
                            Cup size
                        </div>
                        <div className={"mb-4"}>
                            { application.model.cup_size }
                        </div>
                    </div>
                    }
                </div>
            </div>
            <div className={"mt-4 grid grid-cols-1 lg:grid-cols-4 gap-4"}>

                { presentation.should_show_casting_media && application.casting_videos.map((video) => (
                    <div key={video.mux_id} className={"aspect-square rounded-lg overflow-hidden"}>
                        <MuxPlayer theme="minimal" poster="/img/poster-casting-video.png" playbackId={video.mux_id} className={"object-fit aspect-square rounded-lg"} />
                    </div>
                ))}

                {photos.slice(0,8).map((photo) => (
                    <div className={"flex"} id={photo.id}>
                        <img
                            key={photo.path}
                            src={cdn_url + photo.path + '?w=1200&h=1200&fit=crop&crop=faces'}
                            className={'rounded-lg object-cover aspect-square'}
                        />
                    </div>
                ))}
            </div>

            { presentation.should_show_digitals && (
                <div className={`mt-4 grid grid-cols-2 lg:grid-cols-${application.model.digitals.slice(0,8).length} gap-4`}>
                    {application.model.digitals.slice(0,8).map((photo) => (
                        <img
                            key={photo.id}
                            src={cdn_url + photo.path + '?w=1200&h=1200&fit=crop&crop=faces'}
                            className={'cursor-zoom-in rounded-lg'}
                        />
                    ))}
                </div>
            )}

        </div>
    )
}
