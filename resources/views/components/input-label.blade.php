@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2']) }}>
    {{ $value ?? $slot }}
</label>
