<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 12)->unique(); // VH-2024-XKYZ
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->enum('booking_type', ['companion', 'venue', 'fleet', 'package']);
            // Polymorphic provider
            $table->nullableMorphs('bookable'); // bookable_type + bookable_id
            // For fleet bookings
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            // Timing
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->integer('duration_hours');
            // Pricing
            $table->decimal('base_amount', 10, 2);
            $table->decimal('addons_amount', 10, 2)->default(0.00);
            $table->decimal('service_fee', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            // Status
            $table->enum('status', [
                'pending',
                'confirmed',
                'in_progress',
                'completed',
                'cancelled_client',
                'cancelled_provider',
                'disputed',
            ])->default('pending');
            $table->text('special_requests')->nullable();
            $table->json('event_details')->nullable(); // event_type, guest_count, dress_code
            $table->timestamps();
            $table->softDeletes();

            $table->index(['client_id', 'status']);
            $table->index(['booking_type', 'status']);
            $table->index('starts_at');
        });

        Schema::create('booking_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('addon_name', 100); // 'Premium Catering', 'Floral Arrangement', 'Security Detail'
            $table->string('category', 60);    // 'catering', 'decor', 'security', 'transport'
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_addons');
        Schema::dropIfExists('bookings');
    }
};
