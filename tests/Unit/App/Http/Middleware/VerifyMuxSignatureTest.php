<?php

namespace Tests\Unit\App\Http\Middleware;

use App\Http\Middleware\VerifyMuxSignature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

function signedRequest(string $body, string $secret, ?int $timestamp = null): Request
{
    $timestamp ??= time();
    $signature = hash_hmac('sha256', $timestamp . '.' . $body, $secret);

    $request = Request::create('/webhooks/mux', 'POST', [], [], [], [], $body);
    $request->headers->set('Mux-Signature', "t={$timestamp},v1={$signature}");

    return $request;
}

beforeEach(function () {
    config(['services.mux.webhook_secret' => 'test-secret']);
});

test('rejects request when secret not configured', function () {
    config(['services.mux.webhook_secret' => null]);

    $response = (new VerifyMuxSignature)->handle(new Request(), fn () => new Response('ok'));

    expect($response->getStatusCode())->toBe(500);
});

test('rejects request without signature header', function () {
    $response = (new VerifyMuxSignature)->handle(new Request(), fn () => new Response('ok'));

    expect($response->getStatusCode())->toBe(400);
});

test('rejects malformed signature header', function () {
    $request = new Request();
    $request->headers->set('Mux-Signature', 'gibberish');

    $response = (new VerifyMuxSignature)->handle($request, fn () => new Response('ok'));

    expect($response->getStatusCode())->toBe(400);
});

test('rejects request with stale timestamp', function () {
    $request = signedRequest('{}', 'test-secret', time() - 3600);

    $response = (new VerifyMuxSignature)->handle($request, fn () => new Response('ok'));

    expect($response->getStatusCode())->toBe(400);
});

test('rejects request with wrong signature', function () {
    $request = signedRequest('{"type":"video.asset.ready"}', 'wrong-secret');

    $response = (new VerifyMuxSignature)->handle($request, fn () => new Response('ok'));

    expect($response->getStatusCode())->toBe(400);
});

test('passes through valid signed request', function () {
    $request = signedRequest('{"type":"video.asset.ready"}', 'test-secret');

    $response = (new VerifyMuxSignature)->handle($request, fn () => new Response('next-ran', 200));

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toBe('next-ran');
});
