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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->foreignId('farmer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('rental_start_datetime');
            $table->dateTime('rental_end_datetime');
            $table->integer('duration_hours');
            $table->decimal('base_cost', 10, 2);
            $table->boolean('driver_requested')->default(false);
            $table->decimal('driver_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2);
            $table->enum('status', ['pending','confirmed','active','completed','cancelled'])->default('pending');
            $table->enum('payment_status', ['pending','paid','refunded'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
