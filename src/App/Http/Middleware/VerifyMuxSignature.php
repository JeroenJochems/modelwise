<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyMuxSignature
{
    private const TOLERANCE_SECONDS = 300;

    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('services.mux.webhook_secret');

        if (!$secret) {
            return response()->json(['message' => 'Webhook secret not configured'], 500);
        }

        $header = $request->header('Mux-Signature');

        if (!$header) {
            return response()->json(['message' => 'Missing signature'], 400);
        }

        ['t' => $timestamp, 'v1' => $signature] = $this->parseHeader($header);

        if (!$timestamp || !$signature) {
            return response()->json(['message' => 'Malformed signature'], 400);
        }

        if (abs(time() - (int) $timestamp) > self::TOLERANCE_SECONDS) {
            return response()->json(['message' => 'Signature timestamp out of tolerance'], 400);
        }

        $payload = $timestamp . '.' . $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expected, $signature)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        return $next($request);
    }

    /** @return array{t: ?string, v1: ?string} */
    private function parseHeader(string $header): array
    {
        $parts = ['t' => null, 'v1' => null];

        foreach (explode(',', $header) as $segment) {
            [$key, $value] = array_pad(explode('=', trim($segment), 2), 2, null);
            if ($key && $value && array_key_exists($key, $parts)) {
                $parts[$key] = $value;
            }
        }

        return $parts;
    }
}
