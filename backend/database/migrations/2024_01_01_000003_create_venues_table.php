<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->enum('type', ['vip_lounge', 'rooftop_terrace', 'boardroom', 'private_villa', 'yacht', 'penthouse', 'ballroom']);
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('address');
            $table->string('city', 80)->default('Tashkent');
            $table->string('country', 60)->default('Uzbekistan');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('capacity_min')->default(1);
            $table->integer('capacity_max');
            $table->decimal('base_price_per_hour', 10, 2);
            $table->decimal('base_price_half_day', 10, 2)->nullable();
            $table->decimal('base_price_full_day', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->json('images')->nullable(); // array of image URLs
            $table->string('cover_image_url')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->json('rules')->nullable(); // No children, 18+ only, etc.
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'is_active']);
            $table->index('city');
        });

        Schema::create('venue_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('name', 80); // 'Private Bar', 'Butler Service', 'Helipad', etc.
            $table->string('icon', 60)->nullable();
            $table->timestamps();
        });

        Schema::create('venue_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'reserved', 'booked', 'blocked'])->default('available');
            $table->decimal('price_override', 10, 2)->nullable(); // Dynamic pricing
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['venue_id', 'date', 'status']);
            $table->unique(['venue_id', 'date', 'start_time']);
        });

        Schema::create('venue_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('pricing_type', ['flat', 'per_person', 'per_hour'])->default('flat');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_addons');
        Schema::dropIfExists('venue_slots');
        Schema::dropIfExists('venue_amenities');
        Schema::dropIfExists('venues');
    }
};
