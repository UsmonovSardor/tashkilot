<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payer_id')->constrained('users');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'processing', 'captured', 'failed', 'refunded', 'partially_refunded'])->default('pending');
            $table->enum('payment_method', ['stripe', 'payme', 'click', 'bank_transfer', 'crypto'])->default('stripe');
            $table->string('gateway_payment_id')->nullable()->unique(); // Stripe PI id
            $table->string('gateway_customer_id')->nullable();
            $table->json('gateway_metadata')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'status']);
        });

        // The Escrow State Machine
        Schema::create('escrow_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users'); // companion/driver/venue owner
            $table->decimal('held_amount', 10, 2);
            $table->decimal('platform_fee', 10, 2)->default(0.00);   // 15% of held
            $table->decimal('provider_payout', 10, 2);               // held - platform_fee
            $table->enum('state', [
                'holding',      // Funds captured, held in escrow
                'releasing',    // Event completed, release initiated
                'released',     // Funds sent to provider
                'refunding',    // Cancellation, refund in progress
                'refunded',     // Fully refunded to client
                'disputed',     // Dispute opened
                'resolved',     // Dispute resolved by admin
            ])->default('holding');
            $table->timestamp('held_at');
            $table->timestamp('release_scheduled_at')->nullable(); // auto-release 48h after event
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->string('stripe_transfer_id')->nullable();
            $table->string('stripe_refund_id')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['state', 'release_scheduled_at']);
            $table->index('provider_id');
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users');
            $table->foreignId('reviewee_id')->constrained('users');
            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->json('category_ratings')->nullable(); // {'punctuality': 5, 'presentation': 4, ...}
            $table->boolean('is_visible')->default(true);
            $table->timestamps();

            $table->unique(['booking_id', 'reviewer_id']);
            $table->index(['reviewee_id', 'rating']);
        });

        Schema::create('ai_match_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('companion_id')->constrained('companions');
            $table->decimal('score', 5, 4); // 0.0000 - 1.0000
            $table->string('event_type', 60);
            $table->json('matched_skills')->nullable();
            $table->json('matched_languages')->nullable();
            $table->timestamp('computed_at');
            $table->timestamps();

            $table->index(['client_id', 'event_type', 'score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_match_scores');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('escrow_transactions');
        Schema::dropIfExists('payments');
    }
};
