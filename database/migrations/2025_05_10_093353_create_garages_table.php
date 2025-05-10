<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('contact_number');
            $table->decimal('latitude', 10, 8); // Stores values like 19.076090
            $table->decimal('longitude', 11, 8); // Stores values like 72.877426
            $table->string('address');
            $table->text('description')->nullable();
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('is_24_7')->default(false);
            $table->decimal('rating', 2, 1)->default(0);
            $table->timestamps();

            // Add index for location searches
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garages');
    }
};
