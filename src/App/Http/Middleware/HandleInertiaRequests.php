<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'is_impersonating' => app()->make(ImpersonatesUsers::class)->impersonating($request),
            'cdn_url' => env("CDN_URL"),
            'auth' => [
                'user' => $request->user(),
            ],
            'translations' => function () {
                return collect(File::allFiles(base_path('lang/' . app()->getLocale())))
                    ->flatMap(function ($file) {
                        return Arr::dot(
                            File::getRequire($file->getRealPath()),
                            $file->getBasename('.' . $file->getExtension()) . '.'
                        );
                    });
            },
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
