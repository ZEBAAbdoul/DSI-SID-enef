{{-- @props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif --}}

<!-- resources/views/components/input-error.blade.php -->
@props(['field'])

@error($field)
    <span class="text-danger">{{ $message }}</span>
@enderror
