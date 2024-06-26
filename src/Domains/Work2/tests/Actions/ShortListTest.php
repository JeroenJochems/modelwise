<?php

namespace Tests\Work2\Actions;

use Domain\Work2\Actions\Shortlist;
use Domain\Work2\Models\Listing;
use Tests\TestCase;

class ShortListTest extends TestCase
{
    public function test_it_shortlists()
    {
        $listing = Listing::factory()->createOne();

        app(Shortlist::class)->execute($listing);

        $this->assertNotNull($listing->fresh()->shortlisted_at);
    }
}
