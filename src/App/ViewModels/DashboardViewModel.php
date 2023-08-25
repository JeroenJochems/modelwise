<?php

namespace App\ViewModels;

use Domain\Jobs\Data\ApplicationData;
use Domain\Jobs\Data\HireData;
use Domain\Jobs\Data\InviteData;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Domain\Jobs\Models\Invite;
use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelData\DataCollection;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class DashboardViewModel extends ViewModel
{
    /* @var DataCollection|array<InviteData> */
    public $openInvites;

    /* @var DataCollection|array<ApplicationData> */
    public $openApplications;

    /* @var DataCollection|array<HireData> */
    public $hires;

    public function __construct(public Model|Authenticatable $model){
        $this->openInvites = InviteData::collection(
            Invite::query()->open($this->model)->getWithData()
        );

        $this->openApplications = ApplicationData::collection(
            Application::query()->open($this->model)->getWithData()
        );

        $this->hires = HireData::collection(
            Hire::query()->whereModel($this->model)->getWithData()
        );
    }
}
