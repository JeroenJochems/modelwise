<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Data\RegisterModelData;
use Domain\Profiles\Models\Model;
use Illuminate\Support\Facades\Hash;

class RegisterModel
{
    public function __invoke(RegisterModelData $data)
    {
        $model = new Model();
        $model->password = Hash::make($data->password);
        $model->email = $data->email;
        $model->save();

        foreach ($data->viewedRoles as $role_id) {
            $model->role_views()->create([
                'role_id' => $role_id,
            ]);
        }


        return $model;
    }
}
