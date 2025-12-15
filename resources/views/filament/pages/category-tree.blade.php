<x-filament::page>

    {{-- Root wrapper card --}}
    <x-filament::card>

        {{-- Container row --}}
        <div style="display: flex; gap: 2rem;">

            {{-- CATEGORY TREE --}}
            <div style="flex: 1; min-width: 250px;">
                {{-- Add Root Category Button --}}
                <x-filament::button size="sm" icon="heroicon-o-plus" wire:click="createUnder(null)">
                    Add Root Category
                </x-filament::button>

                {{-- Tree List --}}
                <ul style="margin-top: 1rem; list-style: none; padding-left: 0;">
                    @foreach ($categories as $category)
                        @include('filament.pages.partials.tree-node', [
                            'category' => $category,
                            'level' => 0,
                        ])
                    @endforeach
                </ul>
            </div>

            {{-- FORM --}}
            <div style="flex: 1; min-width: 300px;">
                <x-filament::card>
                    <x-slot name="header">
                        {{ $selectedCategoryId ? 'Edit Category' : 'Create Category' }}
                    </x-slot>

                    @if (session()->has('success'))
                        <p class="text-success-600 mb-2 text-sm">
                            {{ session('success') }}
                        </p>
                    @endif

                    <form wire:submit.prevent="save">
                        {{ $this->form }}

                        <x-filament::button type="submit" class="mt-4">
                            Save
                        </x-filament::button>
                    </form>
                </x-filament::card>
            </div>

        </div>

    </x-filament::card>

</x-filament::page>
