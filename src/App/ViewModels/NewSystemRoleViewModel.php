<?php

namespace App\ViewModels;

use DateInterval;
use DatePeriod;
use Domain\Jobs\Data\ListingData;
use Domain\Jobs\Data\RoleData;
use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Models\Model;
use Spatie\ViewModels\ViewModel;

/** @typescript ModelRoleViewModel */
class NewSystemRoleViewModel extends ViewModel
{
    public RoleData $role;
    public ?ListingData $listing = null;

    /** @var array<string> */
    public array $shootDates;

    public bool $hasApplied;
    public bool $hasPassed;
    public bool $isHired;

    public function __construct(array $apiData, int|string $modelId)
    {
        $roleArray = $apiData['role'];
        $this->role = RoleData::from($roleArray);

        if ($apiData['listing']) {
            $listingArray = $apiData['listing'];
            $listingArray['model'] = ModelData::from(Model::find($modelId))->toArray();
            $listingArray['role'] = $roleArray;
            $this->listing = ListingData::from($listingArray);
        }

        $this->hasPassed = !empty($apiData['passed']);

        $startDate = isset($roleArray['start_date'])
            ? new \DateTime($roleArray['start_date'])
            : new \DateTime();
        $endDate = isset($roleArray['end_date'])
            ? new \DateTime($roleArray['end_date'])
            : $startDate;

        $period = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate,
            DatePeriod::INCLUDE_END_DATE
        );

        $this->shootDates = [];
        foreach ($period as $date) {
            $this->shootDates[] = $date->format('Y-m-d');
        }

        $this->hasApplied = !empty($apiData['listing']['applied_at']);
        $this->isHired = !empty($apiData['listing']['hired_at']);
    }
}
