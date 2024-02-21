<button
    {{ $attributes->merge(['class' => 'px-20 py-3 font-semibold text-white transition bg-blue-500 rounded-lg hover:bg-blue-600']) }}
>
    {{ $slot }}
</button>
