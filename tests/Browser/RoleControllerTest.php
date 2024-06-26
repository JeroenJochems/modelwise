<?php

namespace Browser;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use function Pest\testDirectory;

class RoleControllerTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_it_shows_a_role(): void
    {
        $role = Role::factory()->createOne();

        $this->browse(function (Browser $browser) use ($role) {
            $browser->visit(route("roles.show", $role))
                    ->assertSee($role->name);
        });
    }

    public function test_i_can_apply(): void
    {
        $this->browse(function (Browser $browser) {
            $role = Role::factory()->createOne();
            $model = Model::factory()->createOne();

            $browser->loginAs($model->id)
                    ->visit(route("roles.show", $role))
                    ->click("#apply")
                    ->waitFor("h1")
                    ->assertSee("Apply for this role")
            ;
        });
    }

    public function test_it_shows_i_have_applied(): void
    {
        $this->browse(function (Browser $browser) {
            $role = Role::factory()->createOne();
            $model = Model::factory()->createOne();

            $listing = Listing::create([
                'model_id' => $model->id,
                'role_id' => $role->id,
                'applied_at' => now()
            ]);

            $browser->loginAs($model->id)
                    ->visit(route("roles.show", $role))
                    ->assertSee("Thank you for applying to this job!")
            ;
        });
    }
    public function test_it_shows_i_am_shortlisted(): void
    {
        $this->browse(function (Browser $browser) {
            $role = Role::factory()->createOne([
                'extra_fields' => ['casting_photos' => true, 'casting_videos' => true],
                'casting_photo_instructions' => "Please upload a photo",
                'casting_video_instructions' => "Please upload a video",
            ]);
            $model = Model::factory()->createOne();

            $listing = Listing::create([
                'model_id' => $model->id,
                'role_id' => $role->id,
                'applied_at' => now(),
                'shortlisted_at' => now()
            ]);

            $browser->loginAs($model->id)
                    ->visit(route("roles.show", $role))
                    ->assertSee("You've been shortlisted!")
                    ->assertsee('Please upload a photo')
                    ->assertsee('Please upload a video')
            ;
        });
    }
}
