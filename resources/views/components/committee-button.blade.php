@props(['label', 'active' => false])

<button {{ $attributes->merge(['class' => 'w-full text-left px-8 py-5 bg-[#A42503] hover:bg-[#8a1f02] transition-colors rounded-2xl group shadow-md']) }}>
    <span class="text-[#FFB800] font-bold italic text-3xl font-['Instrument_Sans'] tracking-wide">
        {{ $label }}
    </span>
</button>