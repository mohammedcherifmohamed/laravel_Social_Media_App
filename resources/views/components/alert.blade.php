@props(['type' => 'info'])

@php
    $alertId = 'alert_' . uniqid();

    $classes = [
        'info' => 'bg-blue-100 text-blue-800',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
        'error' => 'bg-red-100 text-red-800',
    ];

    $alertClass = $classes[$type] ?? 'bg-gray-100 text-gray-800';
@endphp

<div 
    id="{{ $alertId }}"
    class="px-4 py-3 rounded {{ $alertClass }} transition-opacity duration-500 ease-in-out"
    role="alert"
>
    <strong class="font-semibold capitalize">{{ $type }}:</strong> {{ $slot }}
</div>

<script>
    setTimeout(() => {
        const alert = document.getElementById('{{ $alertId }}');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 2000);
</script>