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
        Schema::create('garage_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->decimal('base_price', 8, 2);
            $table->decimal('per_km_charge', 8, 2)->nullable(); // For mobile services
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage_services');
    }
};
