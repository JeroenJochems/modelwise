<div class="grid gap-4">
    <x-onboarding.step :step="3" :totalSteps="6" />

    <div class="grid grid-cols-1 gap-4 mt-8">
        <x-typography.heading-lg>
            {{ __('Profile set up') }}
        </x-typography.heading-lg>
        <x-typography.text-md>
            {{ __("Upload a headshot in colour as your profile picture.") }}
        </x-typography.text-md>
    </div>

    <form wire:submit.prevent="save" method="POST" class="grid gap-4">
        @csrf

        <input type="file" class="hidden" id="photo" wire:model="photo">

        @if ($photo)
            <div class="mx-auto w-1/2 aspect-[4/3] border border-gray-500">
               <img src="{{ $photo->temporaryUrl() }}" />
            </div>
        @else
            <label for="photo" class="cursor-pointer mx-auto flex items-center justify-center text-center w-1/2 aspect-[3/4] bg-gray-100 border border-gray-500">
                Headshot
                <br />
                <br />
                +
            </label>
        @endif

        @error('photo') <span class="error">{{ $message }}</span> @enderror

        <x-primary-button disabled class="bg-gray-300 mt-4">
            {{ __('Continue') }}
        </x-primary-button>
    </form>
</div>
