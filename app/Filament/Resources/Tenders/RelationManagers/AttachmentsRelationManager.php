<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tenders\RelationManagers;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
    /**
     * The Eloquent relationship name.
     *
     * @var string
     */
    protected static string $relationship = 'attachments';

    /**
     * Panel title.
     *
     * @var string|null
     */
    protected static ?string $title = 'Tender Attachments';

    /**
     * Define attachment upload form.
     *
     * @param  Schema  $schema
     * @return Schema
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('file_path')
                ->label('Attachment File')
                ->disk('public')
                ->directory(function (): string {
                    /** @var Model $tender */
                    $tender = $this->getOwnerRecord();

                    return "tenders/attachments/tender_{$tender->id}";
                })
                ->preserveFilenames()
                ->formatStateUsing(function (?string $state, ?Model $record): ?string {
                    if (! $state || ! $record) {
                        return $state;
                    }

                    return "tenders/attachments/tender_{$record->tender_id}/{$state}";
                })
                ->dehydrateStateUsing(fn (?string $state): ?string => 
                    $state ? basename($state) : null
                )
                ->required(),
        ]);
    }

    /**
     * Define table listing of attachments.
     *
     * @param  Table  $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_name')
                    ->label('File Name')
                    ->searchable()
                    ->url(fn (Model $record): string =>
                        Storage::disk('public')->url(
                            "tenders/attachments/tender_{$record->tender_id}/{$record->file_path}"
                        )
                    )
                    ->openUrlInNewTab(),

                TextColumn::make('mime_type')
                    ->label('Type'),

                TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(fn (?int $state): string =>
                        $state ? number_format($state / 1024, 2) . ' KB' : '-'
                    ),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {

                        /** @var Model $tender */
                        $tender = $this->getOwnerRecord();

                        $data['uploaded_by'] = auth()->id();

                        $relativePath = "tenders/attachments/tender_{$tender->id}/{$data['file_path']}";
                        $fullPath     = Storage::disk('public')->path($relativePath);

                        try {
                            if (file_exists($fullPath)) {
                                $data['original_name'] = $data['file_path'];
                                $data['mime_type']     = mime_content_type($fullPath) ?: null;
                                $data['file_size']     = filesize($fullPath) ?: 0;
                            } else {
                                $data['original_name'] = $data['file_path'];
                                $data['mime_type']     = null;
                                $data['file_size']     = 0;
                            }
                        } catch (Exception $exception) {
                            // Log error in production if needed
                            report($exception);

                            $data['mime_type'] = null;
                            $data['file_size'] = 0;
                        }

                        return $data;
                    }),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Model $record): string =>
                        Storage::disk('public')->url(
                            "tenders/attachments/tender_{$record->tender_id}/{$record->file_path}"
                        )
                    )
                    ->openUrlInNewTab(),

                DeleteAction::make(),
            ]);
    }
}