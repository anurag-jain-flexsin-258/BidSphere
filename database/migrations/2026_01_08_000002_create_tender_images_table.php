<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tender_images', function (Blueprint $table) {
            $table->id();

            // Linked tender
            $table->foreignId('tender_id')
                  ->constrained('tenders')
                  ->cascadeOnDelete();

            // Image path
            $table->string('image');

            // Ordering (optional but useful)
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_images');
    }
};
