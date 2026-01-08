<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tender_attachments', function (Blueprint $table) {
            $table->id();

            // Linked tender
            $table->foreignId('tender_id')
                  ->constrained('tenders')
                  ->cascadeOnDelete();

            // Who uploaded the file (customer or admin)
            $table->foreignId('uploaded_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // File metadata
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_attachments');
    }
};
