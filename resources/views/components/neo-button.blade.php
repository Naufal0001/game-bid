@props(['color' => 'yellow']) 

@php
    $colors = [
        'yellow' => 'bg-yellow-400 hover:bg-yellow-300',
        'red' => 'bg-red-400 hover:bg-red-300',
        'teal' => 'bg-teal-400 hover:bg-teal-300',
        'white' => 'bg-white hover:bg-gray-100',
    ];
    $baseClass = "inline-block px-6 py-3 border-3 border-black font-black uppercase text-sm tracking-wider shadow-neo hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-200";
    $colorClass = $colors[$color] ?? $colors['yellow'];
@endphp

<button {{ $attributes->merge(['class' => "$baseClass $colorClass"]) }}>
    {{ $slot }}
</button>