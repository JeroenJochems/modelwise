<?php

namespace App\ViewModels;

use Domain\Jobs\Models\Invite;
use Domain\Profiles\Data\InviteData;
use Domain\Profiles\Models\Model;
use Spatie\LaravelData\DataCollection;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class DashboardViewModel extends ViewModel
{
    /** @var InviteData[] */
    public DataCollection $openInvites;

    public function __construct(Model $model)
    {
        $this->openInvites = Invite::query()->openForModel(auth()->user())->get();

    }
}
