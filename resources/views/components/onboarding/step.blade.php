@props(['step' => 1, 'totalSteps'])

<div>
    <x-typography.heading-md class="text-center mb-2">
        {{ __('Step :step of :totalSteps', ['step' => $step, 'totalSteps' => $totalSteps]) }}
    </x-typography.heading-md>

    <div class="w-full bg-gray-100 h-2 rounded-full">
        <div style="width: {{ $step / $totalSteps * 100 }}%" class="bg-green h-2 rounded-full"></div>
    </div>
</div>

