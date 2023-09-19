import { useState } from "react";

type UseUploadProgress = {
    id: string
    progress: number
}

export function useUploadProgress() {

    const [uploadingFiles, setUploadingFiles] = useState<UseUploadProgress[]>([]);

    const totalProgressRatio = uploadingFiles.length
        ? (uploadingFiles.reduce(function (sum, item) {
                return sum + item.progress;
            }, 0) / uploadingFiles.length)
        : 0;

    function addFileToProgress(id: string) {
        setUploadingFiles((uploadingFiles) => [
            ...uploadingFiles,
            {id, progress: 0}
        ]);
    }

    function updateProgress(id: string, progress: number) {
        setUploadingFiles((uploadingFiles) => {
            const fileIndex = uploadingFiles.findIndex((file) => file.id === id);
            uploadingFiles[fileIndex].progress = progress;
            return [...uploadingFiles];
        });
    }

    return {
        updateProgress,
        totalProgressRatio,
        addFileToProgress,
    }
}
