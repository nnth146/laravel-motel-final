@props(['active'])

@php
    $classes = $active ?? false
    ? 'text-dark-blue cursor-pointer border-dark-blue flex items-center border-b-2 border-solid px-2 font-semibold'
    : 'text-dark-blue cursor-pointer hover:border-dark-blue flex items-center hover:border-b-2 hover:bg-slate-50 hover:border-solid px-2 font-semibold' 
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
