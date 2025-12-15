<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public ?string $site_tagline;
    public ?string $admin_email;
    public ?string $contact_number;
    public ?string $logo;
    public ?string $favicon;

    public static function group(): string
    {
        return 'general';
    }
}
