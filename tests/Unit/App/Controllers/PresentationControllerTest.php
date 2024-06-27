<?php

namespace Tests\Unit\App\Controllers;

use Domain\Present\Models\Presentation;
use Domain\Work2\Models\Listing;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PresentationControllerTest extends TestCase
{
    public function test_it_shows_a_presentation()
    {
        $listing = Listing::factory()->createOne();
        $presentation = Presentation::create([
            'role_id' => $listing->role_id,
        ]);

        $presentation->presentationListings()->create([
            'listing_id' => $listing->id,
        ]);

        $this->get(route('presentations.show', $presentation))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Roles/Presentation')
                ->has('presentation')
                ->has('listings')
            );

    }
}
