<?php namespace Domain\Models\Actions;

use Domain\Models\Data\ModelData;
use Domain\Models\Models\Model;
use Illuminate\Support\Facades\Hash;

class RegisterModel
{
    public function __invoke(ModelData $data)
    {
        return Model::create([
            ...$data->toArray(),
            'password' => Hash::make($data->password),
        ]);
    }
}

