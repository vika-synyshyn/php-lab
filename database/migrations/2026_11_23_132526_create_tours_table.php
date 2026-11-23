<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manager_id')
                ->constrained('users')->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('tour_categories')->cascadeOnDelete();

            $table->foreignId('destination_id')
                ->constrained('destinations')->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('duration_days');
            $table->decimal('base_price', 10, 2);
            $table->enum('status', [
                'draft', 'pending', 'published', 'archived',
            ])->default('draft');

            $table->timestamps();

            $table->index(['status', 'base_price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
