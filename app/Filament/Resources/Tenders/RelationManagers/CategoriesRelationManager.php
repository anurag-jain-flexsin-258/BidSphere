<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tenders\RelationManagers;

use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesRelationManager extends RelationManager
{
    /**
     * The Eloquent relationship name on the parent model.
     *
     * @var string
     */
    protected static string $relationship = 'categories';

    /**
     * Title shown in the Filament UI.
     *
     * @var string|null
     */
    protected static ?string $title = 'Categories';

    /**
     * Define the table for managing attached categories.
     *
     * @param  Table  $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Category')
                    ->searchable(),
            ])
            ->headerActions([
                Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordTitleAttribute('name'),
            ])
            ->actions([
                Actions\DetachAction::make(),
            ]);
    }
}