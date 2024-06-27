<?php

namespace App\ViewModels;

use DateInterval;
use DatePeriod;
use Domain\Jobs\Data\ListingData;
use Domain\Jobs\Data\RoleData;
use Domain\Jobs\Models\Role;
use Domain\Work2\Models\Listing;
use Spatie\ViewModels\ViewModel;

/** @typescript */
class ModelRoleViewModel extends ViewModel
{
    public RoleData $role;
    public ?ListingData $listing = null;

    /** @var array<string> */
    public array $shootDates;

    public bool $hasApplied;
    public bool $isHired;

    public function __construct(Role $role, Listing $listing = null)
    {
        $this->role = RoleData::from($role->load("job"));

        if ($listing) {
            $listing->load(["casting_photos", "casting_videos"]);
            $this->listing = ListingData::from($listing);
        }

        $period = new DatePeriod(
            $role->start_date,
            new DateInterval('P1D'),
            $role->end_date ?? $role->start_date,
            DatePeriod::INCLUDE_END_DATE
        );

        $this->shootDates = [];
        foreach ($period as $date) {
            $this->shootDates[] = $date->format('Y-m-d');
        }

        $this->hasApplied = !!optional($listing)->applied_at;
        $this->isHired = !!optional($listing)->hired_at;
    }
}
