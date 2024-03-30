<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Vapor\Http\Controllers\SignedStorageUrlController;

class VaporSignedStorageUrl extends SignedStorageUrlController
{
    protected function storageClient()
    {
        $config = [
            'use_path_style_endpoint' => true,
            'region' => 'auto',
            'endpoint' => $_ENV['CLOUDFLARE_R2_ENDPOINT'],
            'credentials' => [
                'key' => $_ENV['CLOUDFLARE_R2_ACCESS_KEY_ID'],
                'secret' => $_ENV['CLOUDFLARE_R2_ACCESS_KEY_SECRET'],
            ],
        ];

        return new S3Client($config);
    }


    public function store(Request $request)
    {
        $this->ensureEnvironmentVariablesAreAvailable($request);

        Gate::authorize('uploadFiles', [
            $request->user(),
            $bucket = $request->input('bucket') ?: $_ENV['CLOUDFLARE_R2_BUCKET'],
        ]);

        $client = $this->storageClient();

        $uuid = (string)Str::uuid();

        $expiresAfter = config('vapor.signed_storage_url_expires_after', 5);

        $signedRequest = $client->createPresignedRequest(
            $this->createCommand(
                $request,
                $client,
                $bucket,
                $key = ('tmp/' . $uuid)),
                sprintf('+%s minutes', $expiresAfter
            )
        );

        $uri = $signedRequest->getUri();

        return response()->json([
            'uuid' => $uuid,
            'key' => $key,
            'url' => $uri->getScheme() . '://' . $uri->getAuthority() . $uri->getPath() . '?' . $uri->getQuery(),
            'headers' => $this->headers($request, $signedRequest),
        ], 201);
    }
}
