<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // General Fields
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->required(),

                Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->nullable(),

                FileUpload::make('image')
                    ->label('Category Image')
                    ->directory('categories/images')
                    ->image()
                    ->maxSize(2048),

                Textarea::make('description')
                    ->rows(4),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                // SEO Fields
                TextInput::make('meta_title'),

                Textarea::make('meta_description')->rows(3),

                Textarea::make('meta_keywords')->rows(2),

                FileUpload::make('meta_image')
                    ->directory('categories/meta')
                    ->image()
                    ->maxSize(2048),

                TextInput::make('canonical_url'),

                Textarea::make('seo_schema')->rows(5),
            ]);
    }
}
