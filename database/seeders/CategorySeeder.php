<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'status' => 'active',
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'parent_id' => 1,
            'status' => 'active',
        ]);
    }
}
