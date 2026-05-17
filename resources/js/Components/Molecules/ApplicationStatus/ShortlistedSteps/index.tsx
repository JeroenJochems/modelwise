import {useForm, router} from "@inertiajs/react";
import {useState} from "react";
import {BaseFile, FileUploader} from "@/Components/FileUploader";
import {useUploadingFields} from "@/Hooks/useUploadingFields";
import PrimaryButton from "@/Components/PrimaryButton";
import {ListingData, RoleData} from "@/types/generated";
import {StepRow} from "./StepRow";

type Props = {
    role: RoleData;
    listing: ListingData;
};

type Form = {
    _method: string;
    casting_photos: BaseFile[];
    casting_videos: BaseFile[];
};

export function ShortlistedSteps({role, listing}: Props) {
    const {isUploading, setUploadingField} = useUploadingFields();
    const [briefAcknowledged, setBriefAcknowledged] = useState<boolean>(!!listing.brief_acknowledged_at);

    const {post, data, processing, setData, errors} = useForm<Form>({
        _method: 'patch',
        casting_photos: [],
        casting_videos: [],
    });

    const hasDocs = !!role.documents && role.documents.length > 0;
    const photosRequested = !!role.extra_fields.casting_photos;
    const videoRequested = !!role.extra_fields.casting_videos;

    const photosOk = !photosRequested || data.casting_photos.filter(f => !f.deleted).length > 0;
    const videoOk = !videoRequested || data.casting_videos.filter(f => !f.deleted && f.muxStatus !== 'errored').length > 0;
    const briefOk = !hasDocs || briefAcknowledged;

    const canSend = briefOk && photosOk && videoOk && !isUploading && !processing;

    const photoCount = data.casting_photos.filter(f => !f.deleted).length;
    const videoCount = data.casting_videos.filter(f => !f.deleted).length;
    const hasProcessingVideo = data.casting_videos.some(f => !f.deleted && f.muxStatus === 'processing');

    function toggleBriefAcknowledged(next: boolean) {
        setBriefAcknowledged(next);
        router.post(route('applications.acknowledge-brief', role.id), {acknowledged: next}, {
            preserveScroll: true,
            preserveState: true,
        });
    }

    function submit() {
        post(route('applications.update', role.id));
    }

    let stepNumber = 0;

    return (
        <div className="grid gap-6">
            <p className="text-gray-600 text-sm leading-relaxed">
                The client wants more before they decide. {[
                    hasDocs && 'Read the brief',
                    photosRequested && 'send photos',
                    videoRequested && 'record a casting video',
                ].filter(Boolean).join(', ')}.
            </p>

            {hasDocs && (
                <StepRow
                    number={++stepNumber}
                    title="Briefing documents"
                    status={briefAcknowledged ? 'done' : 'in_progress'}
                    statusLabel={briefAcknowledged ? 'Read' : 'Required'}
                >
                    <ul className="list-disc pl-5 mb-3 space-y-1">
                        {role.documents!.map(doc => (
                            <li key={doc.id}>
                                <a href={doc.url} target="_blank" rel="noopener" className="underline text-teal">
                                    {doc.filename ?? 'Briefing PDF'}
                                </a>
                            </li>
                        ))}
                    </ul>
                    <label className="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            checked={briefAcknowledged}
                            onChange={(e) => toggleBriefAcknowledged(e.target.checked)}
                        />
                        <span className="text-sm">I've reviewed the brief</span>
                    </label>
                </StepRow>
            )}

            {photosRequested && (
                <StepRow
                    number={++stepNumber}
                    title="Casting photos"
                    status={photoCount > 0 ? 'done' : 'in_progress'}
                    statusLabel={photoCount > 0 ? `${photoCount} added` : 'Required'}
                    instructions={role.casting_photo_instructions}
                >
                    <FileUploader
                        accept="image/*"
                        files={data.casting_photos}
                        error={errors.casting_photos}
                        slots={3}
                        cols={6}
                        colsOnMobile={3}
                        onToggleUploading={(state) => setUploadingField('casting_photos', state)}
                        onUpdate={(casting_photos) => setData(data => ({...data, casting_photos}))}
                        onAdd={(photo) => setData(data => ({...data, casting_photos: [...data.casting_photos, photo]}))}
                    />
                </StepRow>
            )}

            {videoRequested && (
                <StepRow
                    number={++stepNumber}
                    title="Casting video"
                    status={videoOk && !hasProcessingVideo ? 'done' : 'in_progress'}
                    statusLabel={
                        hasProcessingVideo ? 'Processing…' :
                        videoCount > 0 ? 'Uploaded' :
                        'Required'
                    }
                    instructions={role.casting_video_instructions}
                >
                    <FileUploader
                        accept="video/*"
                        files={data.casting_videos}
                        slots={3}
                        cols={3}
                        colsOnMobile={3}
                        onToggleUploading={(state) => setUploadingField('casting_videos', state)}
                        onUpdate={(casting_videos) => setData(data => ({...data, casting_videos}))}
                        onAdd={(file) => setData(data => ({...data, casting_videos: [...data.casting_videos, file]}))}
                    />
                </StepRow>
            )}

            <div className="sticky bottom-0 -mx-4 px-4 py-3 bg-white border-t border-gray-200 sm:static sm:mx-0 sm:p-0 sm:border-0 sm:bg-transparent">
                <PrimaryButton onClick={submit} disabled={!canSend} className="w-full">
                    {processing ? 'Sending…' :
                     isUploading ? 'Uploading…' :
                     hasProcessingVideo ? 'Send anyway (video still processing)' :
                     'Send to client'}
                </PrimaryButton>
            </div>
        </div>
    );
}
