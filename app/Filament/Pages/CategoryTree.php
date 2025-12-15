<?php

namespace App\Filament\Pages;

use App\Models\Category;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\{
    TextInput,
    Textarea,
    Select,
    FileUpload,
    Toggle
};
use Illuminate\Validation\Rule;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class CategoryTree extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Categories';
    protected string $view = 'filament.pages.category-tree';

    public array $data = [];
    public $categories;
    public ?int $selectedCategoryId = null;

    public function mount(): void
    {
        $this->loadCategories();
        $this->form->fill([]);
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->required()
                ->maxLength(255),

            Select::make('parent_id')
                ->label('Parent Category')
                ->options(Category::pluck('name', 'id'))
                ->searchable()
                ->nullable(),

            Textarea::make('description')->rows(3),

            Toggle::make('status')
                ->label('Active')
                ->default(true),

            TextInput::make('sort_order')
                ->numeric()
                ->default(0),

            FileUpload::make('image')
                ->image()
                ->directory('categories')
                ->nullable(),

            TextInput::make('meta_title'),
            Textarea::make('meta_description')->rows(2),
            Textarea::make('meta_keywords')->rows(2),

            FileUpload::make('meta_image')
                ->image()
                ->directory('categories/seo')
                ->nullable(),

            TextInput::make('canonical_url'),
            Textarea::make('seo_schema')->rows(5),
        ];
    }

    public function loadCategories(): void
    {
        $this->categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function selectCategory(int $id): void
    {
        $this->selectedCategoryId = $id;

        $category = Category::findOrFail($id);

        $this->form->fill($category->toArray());
    }

    public function createUnder(?int $parentId = null): void
    {
        $this->selectedCategoryId = null;

        $this->form->fill([
            'parent_id' => $parentId,
            'status' => true,
            'sort_order' => 0,
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'data.name' => 'required|string|max:255',
            'data.slug' => [
                'required',
                Rule::unique('categories', 'slug')->ignore($this->selectedCategoryId),
            ],
        ]);

        // Ensure uploaded files are stored as strings
        $imagePath = is_array($this->data['image'] ?? null)
            ? ($this->data['image']['path'] ?? null)
            : ($this->data['image'] ?? null);

        $metaImagePath = is_array($this->data['meta_image'] ?? null)
            ? ($this->data['meta_image']['path'] ?? null)
            : ($this->data['meta_image'] ?? null);

        $payload = [
            ...$this->data,
            'status' => ($this->data['status'] ?? false) ? 'active' : 'inactive',
            'image' => $imagePath,
            'meta_image' => $metaImagePath,
        ];

        if ($this->selectedCategoryId) {
            Category::findOrFail($this->selectedCategoryId)->update($payload);
        } else {
            Category::create($payload);
        }

        session()->flash('success', 'Category saved successfully.');

        $this->loadCategories();
        $this->form->fill([]);
        $this->selectedCategoryId = null;
    }
}
