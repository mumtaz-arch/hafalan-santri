@props([
    'user' => null,
    'size' => 'md', // Options: xs, sm, md, lg, xl
    'showTooltip' => false,
    'tooltipPosition' => 'top' // Options: top, bottom, left, right
])

@php
    // Fungsi untuk mengambil inisial nama
    $getInitials = function($name) {
        if (!$name) return '?';
        
        $nameParts = explode(' ', trim($name));
        $initials = '';
        
        // Ambil huruf pertama dari maksimal 2 kata
        $count = 0;
        foreach ($nameParts as $part) {
            if ($count >= 2) break;
            
            $initials .= strtoupper(substr($part, 0, 1));
            $count++;
        }
        
        // Jika hanya 1 kata, hanya ambil 1 huruf
        if (count($nameParts) === 1) {
            $initials = strtoupper(substr($nameParts[0], 0, 1));
        }
        
        return $initials;
    };
    
    $initials = $getInitials($user?->name);
    $sizeClasses = match($size) {
        'xxs' => 'w-5 h-5 text-xs',
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl',
        'md' => 'w-10 h-10 text-base', // default
        default => 'w-10 h-10 text-base',
    };
    
    $tooltipClasses = $showTooltip ? "tooltip tooltip-{$tooltipPosition}" : '';
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-full bg-islamic-green text-white font-bold {$sizeClasses} {$tooltipClasses}"]) }}
    @if($showTooltip && $user?->name)
        data-tip="{{ $user->prefixed_name ?? $user->name }}"
    @endif
>
    @if($user && $user->profile_photo)
        <img 
            src="{{ asset('storage/' . $user->profile_photo) }}" 
            alt="{{ $user->prefixed_name ?? $user->name }}"
            class="w-full h-full rounded-full object-cover"
        />
    @else
        <span class="flex items-center justify-center w-full h-full">
            {{ $initials }}
        </span>
    @endif
</div>