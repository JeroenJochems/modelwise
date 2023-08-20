<?php

namespace App\ViewModels;

use Domain\Profiles\Data\ModelData;
use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class ModelMeViewModel extends ViewModel
{
    public ModelData $me;

    public function __construct(Model|Authenticatable $model)
    {
        $this->me = ModelData::from($model);
    }
}
