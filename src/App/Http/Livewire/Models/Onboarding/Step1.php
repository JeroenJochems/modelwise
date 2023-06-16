<?php

namespace App\Http\Livewire\Models\Onboarding;

use Domain\Models\Models\Model;
use Livewire\Component;

class Step1 extends Component
{
    public ?string $first_name;
    public ?string $last_name;
    public ?string $phone_number;
    public ?string $location;

    public function mount()
    {
        /** @var Model $model */
        $model = auth()->user();

        $this->fill($model->only([
            'first_name',
            'last_name',
            'phone_number',
            'location',
        ]));
    }

    public function save()
    {
        $this->validate([
            'first_name' => ['required', 'min:2'],
            'last_name' => ['required', 'min:2'],
            'phone_number' => ['required', 'min:2'],
            'location' => ['required', 'min:2'],
        ]);

        auth()->user()->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
        ]);

        $this->redirect(route('model.onboarding.2'));
    }


    public function render()
    {
        return view('livewire.models.onboarding.step1');
    }
}
