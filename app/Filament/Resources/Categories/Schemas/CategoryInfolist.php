<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Category Name'),
                TextEntry::make('slug'),
                TextEntry::make('parent.name')->label('Parent Category'),
                ImageEntry::make('image')->label('Image'),
                TextEntry::make('description'),

                // SEO Fields
                TextEntry::make('meta_title'),
                TextEntry::make('meta_description'),
                TextEntry::make('meta_keywords'),
                ImageEntry::make('meta_image'),
                TextEntry::make('canonical_url'),
                TextEntry::make('seo_schema'),
            ]);
    }
}
