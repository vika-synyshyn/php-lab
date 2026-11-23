<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_moderation_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()->restrictOnDelete();

            $table->foreignId('moderator_id')
                ->constrained('users')->restrictOnDelete();

            $table->string('decision');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->index(['tour_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_moderation_records');
    }
};
