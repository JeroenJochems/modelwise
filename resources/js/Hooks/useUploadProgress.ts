import {useEffect, useState} from "react";

type UseUploadProgress = {
    id: string
    progress: number
}

export function useUploadProgress() {

    const [uploadingFiles, setUploadingFiles] = useState<UseUploadProgress[]>([]);
    const [totalProgressRatio, setTotalProgressRatio] = useState(0.0);

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

        setTotalProgressRatio(
            uploadingFiles.length
            ? (uploadingFiles.reduce(function (sum, item) {
                return sum + item.progress;
            }, 0) / uploadingFiles.length)
            : 0
        );
    }

    useEffect(() => {
        const timeout = setTimeout(() => {
            if (totalProgressRatio > 0) {
                setTotalProgressRatio(1);
            }
        }, 5000);

        return () => clearTimeout(timeout);
    }, [totalProgressRatio]);

    return {
        uploadingFiles,
        updateProgress,
        totalProgressRatio,
        addFileToProgress,
    }
}
