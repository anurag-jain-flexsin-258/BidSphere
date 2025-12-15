<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSetting extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string|UnitEnum|null $navigationGroup = 'General Settings';
    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->label('Site Name')
                    ->required(),
                TextInput::make('site_tagline')
                    ->label('Site Tagline'),
                TextInput::make('admin_email')
                    ->email()
                    ->label('Admin Email'),
                TextInput::make('contact_number')
                    ->label('Contact Number'),
                FileUpload::make('logo')
                        ->image()
                        ->label('Logo')
                        ->directory('settings'),
                FileUpload::make('favicon')
                        ->image()
                        ->label('Favicon')
                        ->directory('settings'),
            ]);
    }
}






