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

        $html = file_get_contents(resource_path("landing/{$locale}/{$page}.html"));

        $html = str_replace('"/landing/assets/', '"'.asset('landing/assets').'/', $html);

        return response($html)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
