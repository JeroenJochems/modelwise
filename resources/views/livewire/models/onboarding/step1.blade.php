<div class="grid gap-4">
    <x-onboarding.step :step="2" :totalSteps="6" />

    <div class="grid grid-cols-1 gap-4 mt-8">
        <x-typography.heading-lg class="text-center">
            {{ __('Personal details') }}
        </x-typography.heading-lg>
    </div>

    <form wire:submit.prevent="save" method="POST" class="grid gap-4">
        @csrf

        <x-forms.input name="first_name" title="First name" />
        <x-forms.input name="last_name" title="Last name" />
        <x-forms.input name="phone_number" title="Phone number" type="tel" />
        <x-forms.input name="location" title="Location: where are you currently based?" />
{{--                <x-forms.input name="gender" title="Gender" :options="['m' => 'Male', 'f' => 'Female']" />--}}


        <x-primary-button class="mt-4">
            {{ __('Continue') }}
        </x-primary-button>
    </form>
</div>
