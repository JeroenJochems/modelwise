import {useEffect} from "react";
import {router} from "@inertiajs/react";

type WithMuxStatus = { muxStatus?: string };

export function useVideoProcessingPoll(videos: WithMuxStatus[], options: { only?: string[]; intervalMs?: number } = {}) {
    const {only, intervalMs = 5000} = options;
    const hasProcessing = videos.some(v => v.muxStatus === 'processing');

    useEffect(() => {
        if (!hasProcessing) return;

        const handle = setInterval(() => {
            router.reload({ only });
        }, intervalMs);

        return () => clearInterval(handle);
    }, [hasProcessing, intervalMs, only?.join('|')]);
}
