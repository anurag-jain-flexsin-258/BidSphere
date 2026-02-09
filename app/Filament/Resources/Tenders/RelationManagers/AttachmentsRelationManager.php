<?php

namespace App\Filament\Resources\Tenders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';
    protected static ?string $title = 'Tender Attachments';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('file_path')
                ->directory('tenders/attachments')
                ->preserveFilenames()
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_name')
                    ->label('File Name')    
                    ->searchable(),

                TextColumn::make('mime_type')
                    ->label('Type'),

                TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? number_format($state / 1024, 2) . ' KB'
                            : '-'
                    ),
                    
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                Action::make('view')
                        ->label('View')
                        ->icon('heroicon-o-eye')
                        ->url(fn ($record) =>
                            Storage::disk('public')->url(
                                'tenders/attachments/tender_' . $record->tender_id . '/' . $record->file_path
                            )
                        )
                        ->openUrlInNewTab(),
                DeleteAction::make(),
            ]);
    }
}
