<?php

namespace Tests\Unit\Domains\Jobs\Data;

use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Role;
use Tests\TestCase;

class RoleDataTest extends TestCase
{
    public function test_it_can_create_role_data()
    {
        $role = Role::factory()->create(['extra_fields' => ['casting_photos' => true, 'casting_videos' => false]]);

        $data = RoleData::collect(
            Role::all()
        );


        expect($data->count())->toBe(1)
            ->and($data->first()->extra_fields->casting_photos)->toBe(true)
            ->and($data->first()->extra_fields->casting_videos)->toBe(false);
    }
}
