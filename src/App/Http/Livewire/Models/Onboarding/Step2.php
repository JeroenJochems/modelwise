<?php

namespace App\Http\Livewire\Models\Onboarding;

use Domain\Models\Models\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class Step2 extends Component
{
    use WithFileUploads;

    public $photo;

    public function mount()
    {
        /** @var Model $model */
        $model = auth()->user();
    }

    public function save()
    {

    }


    public function render()
    {
        return view('livewire.models.onboarding.step2');
    }
}
