<?php

namespace App\Http\Controllers;

use App\Mail\CleanMail;
use App\Mail\ClientSubmittedPreference;
use Domain\Jobs\Data\ListingData;
use Domain\Present\Data\PresentationData;
use Domain\Present\Models\Presentation;
use Domain\Work2\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PresentationController extends Controller
{
    public function show(Presentation $presentation)
    {
        $presentation->load("role.job");

        $listings = $presentation->presentationListings()
                ->orderBy('order_column')
                ->with([
                    "listing.role",
                    "listing.photos",
                    "listing.model.digitals",
                    "listing.model.portfolio",
                    "listing.casting_photos",
                    "listing.casting_videos",
                ])
                ->get()
                ->pluck("listing");

        return Inertia::render('Roles/Presentation')
            ->with("presentation", PresentationData::from($presentation))
            ->with("listings", ListingData::collect($listings));
    }

    public function favorite(Presentation $presentation, Request $request)
    {
        $favorites = $request->get("favoriteListings");

        $allListings = $presentation->presentationListings()
            ->with("listing.model.digitals", "listing.casting_videos", "listing.model.portfolio")
            ->get()
            ->pluck("listing");

        $favoritedListings = $allListings->filter(function ($listing) use ($favorites) {
            return in_array($listing->id, $favorites);
        });

        $names = $favoritedListings->pluck('model.name');

        foreach ($allListings as $listing) {
            if ($listing->favorited_at && !in_array($listing->id, $favorites)) {
                $listing->favorited_at = null;
            }

            if (!$listing->favorited_at && in_array($listing->id, $favorites)) {
                $listing->favorited_at = now();
            }

            $listing->save();
        }

        Mail::to($presentation->role->job->responsible_user)
            ->send(new CleanMail(
                messageSubject: "Client has submitted favorites",
                messageContent: [
                    "The client has submitted preferences for the following models:",
                    ...$names
                ],
                actionText: "View presentation",
                actionUrl: route("presentations.show", $presentation)
            ));

        return Inertia::render('Roles/PrelistSubmitted')->with("role", $presentation->role);
    }
}
