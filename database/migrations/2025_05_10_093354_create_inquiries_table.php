<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('garage_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->string('vehicle_type'); // bike/car
            $table->text('problem_description');
            $table->decimal('latitude', 10, 8); // Store latitude separately
            $table->decimal('longitude', 11, 8); // Store longitude separately            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('estimated_price', 8, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled']);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE garages ADD location POINT AFTER longitude');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
