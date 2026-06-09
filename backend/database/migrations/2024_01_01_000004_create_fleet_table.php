<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make', 60);        // Rolls-Royce
            $table->string('model', 80);       // Phantom VIII
            $table->integer('year');
            $table->string('color', 40);
            $table->string('license_plate', 20)->unique();
            $table->enum('category', ['ultra_luxury', 'luxury', 'suv', 'limousine', 'sports']);
            $table->integer('passenger_capacity')->default(4);
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('airport_transfer_rate', 10, 2)->nullable();
            $table->string('cover_image_url');
            $table->json('images')->nullable();
            $table->json('features')->nullable(); // ['Champagne Bar', 'Starlight Headliner', 'Massage Seats']
            $table->enum('status', ['available', 'on_trip', 'maintenance', 'reserved'])->default('available');
            $table->string('current_driver_id')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'status']);
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('license_number', 40)->unique();
            $table->string('license_class', 20)->default('B');
            $table->integer('experience_years')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_trips')->default(0);
            $table->json('languages')->nullable(); // ['English', 'Russian', 'Uzbek']
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->json('certifications')->nullable(); // ['Defensive Driving', 'VIP Protocol']
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_available', 'is_verified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicles');
    }
};
