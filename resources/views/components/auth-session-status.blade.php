@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'fw-semibold text-center']) }}>
        {{ $status }}
    </div>
@endif
