<div {{ $attributes->merge(['class' => 'bg-white border-3 border-black shadow-neo p-6']) }}>
    @if(isset($title))
        <h3 class="text-2xl font-black mb-4 uppercase">{{ $title }}</h3>
    @endif
    
    <div class="text-gray-800 font-medium">
        {{ $slot }}
    </div>
</div>