<?php

namespace Domain\Models\Actions;

use Domain\Models\Data\RegisterModelData;
use Domain\Models\Models\Model;
use Illuminate\Support\Facades\Hash;

class RegisterModel
{
    public function __invoke(RegisterModelData $data)
    {
        $model = new Model();
        $model->password = $data->password;
        $model->email = $data->email;
        $model->save();

        return $model;
    }
}
