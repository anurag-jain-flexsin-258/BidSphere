<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'closed' => 'Closed',
        ])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('approved_at'),
                TextInput::make('approved_by')
                    ->numeric(),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('expires_at'),
            ]);
    }
}
