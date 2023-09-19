import {useState} from "react";

export function useUploadingFields() {

    const [uploadingFields, setUploadingFields] = useState<string[]>([]);

    function setUploadingField(field: string, isActive: boolean) {
        if (isActive) {
            setUploadingFields([...uploadingFields, field]);
        }
        else {
            setUploadingFields(uploadingFields.filter((item) => item !== field));
        }
    }


    return {
        isUploading: uploadingFields.length > 0,
        uploadingFields,
        setUploadingField
    }
}
