@props([
    'type' => 'success',
    'message' => null,
    'session' => null,
])

@php
    $classes = match ($type) {
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
        default => 'bg-green-100 border-green-500 text-green-700',
    };

    $displayMessage = $message ?? session($session);
@endphp

@if ($displayMessage)
    <div x-data="{ show: true }" x-show="show" x-transition  x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-20 right-5 z-100 rounded-md border-l-4 p-3 mb-4 shadow-lg animate-slide-in-right {{ $classes }}"
        role="alert">
        <p class="text-sm">{{ $displayMessage }}</p>
    </div>
@endif
