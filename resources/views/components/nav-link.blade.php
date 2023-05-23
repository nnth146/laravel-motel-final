@props(['active'])

@php
    $classes = $active ?? false ? 'text-dark-blue block rounded-md p-2 text-xl font-semibold bg-slate-100' : 'text-dark-blue block rounded-md p-2 text-xl font-semibold hover:bg-slate-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
