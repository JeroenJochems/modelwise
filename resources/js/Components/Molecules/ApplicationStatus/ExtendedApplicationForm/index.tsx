import {useForm} from "@inertiajs/react";
import {H2} from "@/Components/Typography/H2";
import {P} from "@/Components/Typography/p";
import {useUploadingFields} from "@/Hooks/useUploadingFields";
import PrimaryButton from "@/Components/PrimaryButton";
import {BaseFile, FileUploader} from "@/Components/FileUploader";
import {ListingData, RoleData} from "@/types/generated";


type Props = {
    role: RoleData
    listing: ListingData
}

type Form = {
    _method: string;
    casting_photos: BaseFile[];
    casting_videos: BaseFile[];
}
export function ExtendedApplicationForm({ listing, role }: Props) {

    const { isUploading, setUploadingField } = useUploadingFields();

    const { post, data, processing, setData, errors } = useForm<Form>({
        _method: 'patch',
        casting_photos: [],
        casting_videos: [],
    });

    function submit() {
        post(route('applications.update', role.id));
    }

    return (
        <div className={"grid gap-4"}>
            { role.extra_fields.casting_photos && (
                <div>
                    <H2>Casting photos</H2>
                    <P className={"mb-2 whitespace-pre-wrap"}>{ role.casting_photo_instructions}</P>

                    <FileUploader
                        accept="image/*"
                        files={data.casting_photos}
                        error={errors.casting_photos}
                        onToggleUploading={(state) => setUploadingField('casting_photos', state)}
                        onUpdate={(casting_photos) => setData(data => ({...data, casting_photos}))}
                        onAdd={(photo) => setData(data => ({...data, casting_photos: [...data.casting_photos, photo]}))}
                    />
                </div>
            )}


            { role.extra_fields.casting_videos && (
                <div>
                    <H2>Casting video</H2>
                    <P className={"mb-2 whitespace-pre-wrap"}>{ role.casting_video_instructions}</P>

                    <FileUploader
                        accept={"video/*"}
                        files={data.casting_videos}
                        onToggleUploading={(state) => setUploadingField('casting_videos', state)}
                        onUpdate={(casting_videos) => setData(data => ({...data, casting_videos}))}
                        onAdd={(file) => setData(data => ({...data, casting_videos: [...data.casting_videos, file]}))}
                    />
                </div>
            )}

            <PrimaryButton onClick={submit} className={"mb-8 w-ful"} disabled={isUploading || processing}>
                { processing ? "Please wait..." : "Submit"}
            </PrimaryButton>

        </div>
    );
}
