@props(['type' => 'text', 'title', 'name', 'options' => []])

<div>
    <x-input-label :for="$name" :value="__($title)" />

    @if($options)
        <select :wire-model.lazy={{$name}} {!! $attributes->merge(['class' => 'w-full border-gray-300 focus:border-green focus:ring-green rounded-md shadow-sm']) !!}>
            @if (!old($name))
                <option></option>
            @endif
            @foreach ($options as $var=>$val)
                <option name="{{$var}}">{{$val}}</option>
            @endforeach
        </select>
    @else
        <x-text-input :id="$name" class="block mt-1 w-full" :type="$type" :wire:model="$name" :value="old($name)" />
    @endif

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
