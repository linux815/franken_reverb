@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => '
            block w-full rounded-md
            bg-white text-gray-900 placeholder:text-gray-400
            border border-gray-300
            shadow-sm
            px-3 py-2
            focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none

            dark:bg-gray-900 dark:text-gray-100 dark:placeholder:text-gray-500
            dark:border-gray-700 dark:focus:border-indigo-400 dark:focus:ring-indigo-400
        '
    ]) !!}
>
