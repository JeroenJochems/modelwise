<?php

namespace App\Http\Controllers;

use Domain\Profiles\Models\Video;
use Domain\Profiles\Services\Mux\MuxClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateMuxDirectUploadController extends Controller
{
    public function __invoke(Request $request, MuxClient $mux): JsonResponse
    {
        Gate::authorize('uploadFiles', [$request->user()]);

        try {
            $upload = $mux->createDirectUpload(config('app.url'));
        } catch (\Throwable $e) {
            Log::error('Mux direct upload creation failed', [
                'user_id' => $request->user()?->getAuthIdentifier(),
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Could not start upload. Please try again.',
            ], 502);
        }

        $video = new Video();
        $video->videoable()->associate($request->user());
        $video->folder = Video::FOLDER_DRAFT;
        $video->path = '';
        $video->setAttribute('mux_upload_id', $upload->id);
        $video->setAttribute('mux_status', 'pending');
        $video->save();

        return response()->json([
            'upload_id' => $upload->id,
            'url' => $upload->url,
        ], 201);
    }
}
