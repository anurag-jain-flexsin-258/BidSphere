<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tenders\RelationManagers;

use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ImagesRelationManager extends RelationManager
{
    /**
     * The Eloquent relationship name.
     *
     * @var string
     */
    protected static string $relationship = 'images';

    /**
     * Title displayed in Filament panel.
     *
     * @var string|null
     */
    protected static ?string $title = 'Tender Images';

    /**
     * Define the form schema for creating/editing images.
     *
     * @param  Schema  $schema
     * @return Schema
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Tender Image')
                ->image()
                ->disk('public')
                ->directory(function (): string {
                    /** @var Model $tender */
                    $tender = $this->getOwnerRecord();

                    return "tenders/images/tender_{$tender->id}";
                })
                ->formatStateUsing(function (?string $state, ?Model $record): ?string {
                    if (! $state || ! $record) {
                        return $state;
                    }

                    return "tenders/images/tender_{$record->tender_id}/{$state}";
                })
                ->dehydrateStateUsing(fn (?string $state): ?string => 
                    $state ? basename($state) : null
                )
                ->required(),

            TextInput::make('sort_order')
                ->label('Sort Order')
                ->numeric()
                ->default(0),
        ]);
    }

    /**
     * Define the table structure for listing images.
     *
     * @param  Table  $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Preview')
                    ->disk('public')
                    ->visibility('public')
                    ->getStateUsing(function (Model $record): string {
                        return "tenders/images/tender_{$record->tender_id}/{$record->image}";
                    })
                    ->height(50)
                    ->width(50)
                    ->square(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->defaultSort('sort_order');
    }
}