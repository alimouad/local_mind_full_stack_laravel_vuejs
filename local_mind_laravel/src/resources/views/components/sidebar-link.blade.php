@props([
    'href',
    'icon',
    'label',
    'active' => false
])

@php
    $classes = $active
        ? 'bg-student text-white shadow-lg shadow-emerald-100'
        : 'text-slate-400 hover:text-student hover:bg-emerald-50/50';
@endphp

<a href="{{ $href }}"
   class="flex items-center justify-between group p-4 rounded-2xl transition-all duration-300 {{ $classes }}">
    
    <div class="flex items-center gap-4">
        <i data-lucide="{{ $icon }}" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
        <span class="font-bold text-sm tracking-tight">{{ $label }}</span>
    </div>

    @if($active)
        <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
    @endif
</a>
