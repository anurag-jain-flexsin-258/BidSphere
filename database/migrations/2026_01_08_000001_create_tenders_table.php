<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();

            // Owner (Customer who created the tender)
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();

            // Core tender details
            $table->string('title');
            $table->text('description');
            $table->integer('quantity')->default(1);

            // Tender lifecycle status
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'closed'
            ])->default('pending');

            // Admin review fields
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Visibility & control
            $table->boolean('is_featured')->default(false);
            $table->timestamp('expires_at')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
