<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Vapor\Http\Controllers\SignedStorageUrlController;

class VaporSignedStorageUrl extends SignedStorageUrlController
{
    public function store(Request $request)
    {
        $this->ensureEnvironmentVariablesAreAvailable($request);

        Gate::authorize('uploadFiles', [
            $request->user(),
            $bucket = $request->input('bucket') ?: $_ENV['AWS_BUCKET'],
        ]);

        $client = $this->storageClient();

        $uuid = (string)Str::uuid();

        $expiresAfter = config('vapor.signed_storage_url_expires_after', 5);

        $signedRequest = $client->createPresignedRequest(
            $this->createCommand($request, $client, $bucket, $key = ('tmp/' . $uuid)),
            sprintf('+%s minutes', $expiresAfter)
        );

        $uri = $signedRequest->getUri();

        return response()->json([
            'uuid' => $uuid,
            'bucket' => $bucket,
            'key' => $key,
            'url' => $uri->getScheme() . '://' . $uri->getAuthority() . $uri->getPath() . '?' . $uri->getQuery(),
            'headers' => $this->headers($request, $signedRequest),
        ], 201);
    }
}
