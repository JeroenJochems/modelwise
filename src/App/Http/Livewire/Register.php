<?php

namespace App\Http\Livewire;

use App\Providers\RouteServiceProvider;
use Domain\Models\Data\ModelData;
use Domain\Models\Models\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public array $model = [];

    public function submit()
    {

        $data = ModelData::fromLivewire($this->model);

        $model = new Model();
        $model->email = $data->email;
        $model->password = $data->password;
        $model->save();

        Auth::login($model);

        return redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.register');
    }
}
