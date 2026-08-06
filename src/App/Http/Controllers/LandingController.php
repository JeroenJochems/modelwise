<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public const LOCALES = ["nl", "en", "fr", "de", "es"];

    public function index(string $locale = "nl")
    {
        return $this->page("landing", $locale);
    }

    public function faq(string $locale = "nl")
    {
        return $this->page("faq", $locale);
    }

    private function page(string $page, string $locale)
    {
        abort_unless(in_array($locale, self::LOCALES), 404);

        app()->setLocale($locale);

        return response()->file(resource_path("landing/{$locale}/{$page}.html"));
    }
}
