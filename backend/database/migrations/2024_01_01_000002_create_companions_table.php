<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('age');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('photos_blurred')->default(true); // Privacy masking
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('half_day_rate', 10, 2)->nullable(); // 4-hour package
            $table->decimal('full_day_rate', 10, 2)->nullable(); // 8-hour package
            $table->enum('availability_status', ['available', 'busy', 'on_assignment', 'inactive'])->default('available');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_bookings')->default(0);
            $table->string('headline', 120)->nullable(); // "International Business Etiquette Expert"
            $table->text('full_bio')->nullable();
            $table->json('event_types')->nullable(); // ['corporate', 'social', 'travel', 'gala']
            $table->json('ai_embedding')->nullable(); // For AI matching (OpenAI vector)
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['availability_status', 'is_verified', 'rating']);
            $table->index('hourly_rate');
        });

        Schema::create('companion_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->constrained()->cascadeOnDelete();
            $table->string('language', 60);
            $table->enum('proficiency', ['native', 'fluent', 'conversational', 'basic']);
            $table->timestamps();

            $table->index('language');
        });

        Schema::create('companion_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->constrained()->cascadeOnDelete();
            $table->string('skill_name', 100);
            $table->string('category', 60); // 'social', 'business', 'cultural', 'creative'
            $table->text('description')->nullable();
            $table->integer('years_experience')->default(0);
            $table->timestamps();
        });

        Schema::create('companion_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->constrained()->cascadeOnDelete();
            $table->string('original_url');
            $table->string('blurred_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('companion_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->constrained()->cascadeOnDelete();
            $table->enum('day_of_week', ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'])->nullable();
            $table->date('specific_date')->nullable();
            $table->time('available_from');
            $table->time('available_until');
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();

            $table->index(['companion_id', 'specific_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companion_availability');
        Schema::dropIfExists('companion_photos');
        Schema::dropIfExists('companion_skills');
        Schema::dropIfExists('companion_languages');
        Schema::dropIfExists('companions');
    }
};
