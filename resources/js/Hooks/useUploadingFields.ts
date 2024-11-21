import {useState} from "react";

export function useUploadingFields() {

    const [uploadingFields, setUploadingFields] = useState<string[]>([]);

    function setUploadingField(field: string, isActive: boolean) {
        if (isActive) {
            setUploadingFields((state) => [...state, field]);
        }
        else {
            setUploadingFields((state) => [...state].filter((item) => item !== field));
        }
    }


    return {
        isUploading: uploadingFields.length > 0,
        uploadingFields,
        setUploadingField
    }
}
