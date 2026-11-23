<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->date('departure_date');
            $table->unsignedInteger('capacity');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('available_places');
            $table->string('status');
            $table->timestamps();

            $table->index(['departure_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_departures');
    }
};
