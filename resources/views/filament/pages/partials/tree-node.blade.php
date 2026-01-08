@php
    // Define background gray shades for each level
    $bgLevels = [
        0 => '#111827', // root: blackish
        1 => '#374151', // dark gray
        2 => '#6b7280', // medium gray
        3 => '#9ca3af', // light gray
        4 => '#d1d5db', // very light gray
    ];

    // Fallback to last color if level exceeds defined
    $bgColor = $bgLevels[$level] ?? end($bgLevels);
@endphp

<li>
    <x-filament::section :collapsible="false">
        <div style="display: flex; align-items: center; gap: 0.5rem;">

            {{-- Indent for each level --}}
            @for ($i = 1; $i < $level; $i++)
                <span style="display:inline-block; width: 16px;"></span>
            @endfor

            {{-- L connector for current child --}}
            @if($level > 0)
                <span style="font-weight: bold;">└─</span>
            @endif

            {{-- Category button with ID displayed --}}
            <x-filament::button
                size="sm"
                style="background-color: {{ $bgColor }}; color: white;"
                wire:click="selectCategory({{ $category->id }})"
            >
                {{ $category->name }} (ID: {{ $category->id }})
            </x-filament::button>

            {{-- Add child button --}}
            <x-filament::icon-button
                icon="heroicon-o-plus"
                size="xs"
                wire:click="createUnder({{ $category->id }})"
            />
        </div>
    </x-filament::section>

    {{-- Render children recursively --}}
    @if ($category->children->count())
        <ul style="list-style: none; padding-left: 0; margin-top: 0.25rem;">
            @foreach ($category->children as $child)
                @include('filament.pages.partials.tree-node', [
                    'category' => $child,
                    'level' => $level + 1,
                ])
            @endforeach
        </ul>
    @endif
</li>
