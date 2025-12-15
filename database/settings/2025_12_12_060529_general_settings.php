<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $general = [
            'site_name' => 'BidSphere Marketplace',
            'site_tagline' => 'Your Bidding Platform',
            'admin_email' => 'admin@bidsphere.com',
            'contact_number' => '+911234567890',
            'logo' => null,
            'favicon' => null,
        ];

        foreach ($general as $name => $value) {
            DB::table('settings')->insert([
                'group' => 'general',
                'name' => $name,
                'payload' => json_encode($value),
                'locked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('group', 'general')->delete();
    }
};
