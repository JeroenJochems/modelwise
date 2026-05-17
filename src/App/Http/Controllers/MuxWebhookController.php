<?php

namespace App\Http\Controllers;

use Domain\Profiles\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MuxWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse|Response
    {
        $type = (string) $request->input('type');
        $data = (array) $request->input('data', []);

        return match ($type) {
            'video.upload.asset_created' => $this->onUploadAssetCreated($data),
            'video.asset.ready'          => $this->onAssetReady($data),
            'video.asset.errored'        => $this->onAssetErrored($data),
            default                      => response()->noContent(),
        };
    }

    private function onUploadAssetCreated(array $data): JsonResponse
    {
        $uploadId = $data['upload_id'] ?? $data['id'] ?? null;
        $assetId = $data['asset_id'] ?? null;

        if (!$uploadId || !$assetId) {
            return response()->json(['message' => 'Missing upload_id or asset_id'], 422);
        }

        $video = Video::where('mux_upload_id', $uploadId)->first();

        if (!$video) {
            Log::warning('Mux upload.asset_created for unknown upload', ['upload_id' => $uploadId]);
            return response()->json(['message' => 'ok'], 200);
        }

        $video->mux_asset_id = $assetId;
        $video->mux_status = 'processing';
        $video->save();

        return response()->json(['message' => 'ok']);
    }

    private function onAssetReady(array $data): JsonResponse
    {
        $assetId = $data['id'] ?? null;
        $playbackIds = $data['playback_ids'] ?? [];

        if (!$assetId) {
            return response()->json(['message' => 'Missing asset id'], 422);
        }

        $video = Video::where('mux_asset_id', $assetId)->first();

        if (!$video) {
            Log::warning('Mux asset.ready for unknown asset', ['asset_id' => $assetId]);
            return response()->json(['message' => 'ok']);
        }

        $publicPlayback = collect($playbackIds)->firstWhere('policy', 'public');

        if ($publicPlayback && !empty($publicPlayback['id'])) {
            $video->mux_id = $publicPlayback['id'];
        }

        $video->mux_status = 'ready';
        $video->mux_error = null;
        $video->save();

        return response()->json(['message' => 'ok']);
    }

    private function onAssetErrored(array $data): JsonResponse
    {
        $assetId = $data['id'] ?? null;
        $errors = $data['errors'] ?? [];
        $reason = $errors['messages'][0] ?? ($errors['type'] ?? 'unknown error');

        if (!$assetId) {
            return response()->json(['message' => 'Missing asset id'], 422);
        }

        $video = Video::where('mux_asset_id', $assetId)->first();

        if (!$video) {
            Log::warning('Mux asset.errored for unknown asset', ['asset_id' => $assetId]);
            return response()->json(['message' => 'ok']);
        }

        $video->mux_status = 'errored';
        $video->mux_error = is_string($reason) ? $reason : json_encode($reason);
        $video->save();

        Log::error('Mux asset errored', [
            'video_id' => $video->id,
            'asset_id' => $assetId,
            'reason' => $video->mux_error,
        ]);

        return response()->json(['message' => 'ok']);
    }
}
