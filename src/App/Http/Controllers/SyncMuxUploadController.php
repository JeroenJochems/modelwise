<?php

namespace App\Http\Controllers;

use Domain\Profiles\Models\Video;
use Domain\Profiles\Services\Mux\MuxClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyncMuxUploadController extends Controller
{
    public function __invoke(Request $request, MuxClient $mux, string $uploadId): JsonResponse
    {
        $video = Video::where('mux_upload_id', $uploadId)->first();

        if (!$video) {
            return response()->json(['message' => 'Unknown upload'], 404);
        }

        if (!$this->canSync($request, $video)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            if (!$video->mux_asset_id) {
                $lookup = $mux->getDirectUpload($uploadId);
                if ($lookup->assetId) {
                    $video->setAttribute('mux_asset_id', $lookup->assetId);
                    if ($video->mux_status === 'pending') {
                        $video->setAttribute('mux_status', 'processing');
                    }
                    $video->save();
                }
            }

            if ($video->mux_asset_id && $video->mux_status !== 'ready' && $video->mux_status !== 'errored') {
                $asset = $mux->getAsset($video->mux_asset_id);

                if ($asset->status === 'ready') {
                    if ($asset->playbackId) {
                        $video->mux_id = $asset->playbackId;
                    }
                    $video->setAttribute('mux_status', 'ready');
                    $video->setAttribute('mux_error', null);
                    $video->save();
                } elseif ($asset->status === 'errored') {
                    $video->setAttribute('mux_status', 'errored');
                    $video->save();
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Mux sync failed', [
                'upload_id' => $uploadId,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => $video->mux_status,
            'mux_id' => $video->mux_id,
            'mux_error' => $video->mux_error,
        ]);
    }

    private function canSync(Request $request, Video $video): bool
    {
        $user = $request->user();
        if (!$user) {
            return false;
        }

        if ($video->videoable_type === 'model' && $video->videoable_id === $user->getAuthIdentifier()) {
            return true;
        }

        return false;
    }
}
