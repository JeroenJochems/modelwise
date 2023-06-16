@props(['value'])

<p {{ $attributes->merge(['class' => 'block font-medium text-md text-gray-700']) }}>
    {{ $value ?? $slot }}
</p>
