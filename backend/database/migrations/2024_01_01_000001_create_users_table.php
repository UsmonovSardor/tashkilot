<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['client', 'companion', 'driver', 'admin'])->default('client');
            $table->enum('status', ['active', 'suspended', 'pending_verification'])->default('pending_verification');
            $table->boolean('email_verified')->default(false);
            $table->string('phone', 20)->nullable()->unique();
            $table->string('invitation_code', 12)->nullable()->unique();
            $table->string('referred_by')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['role', 'status']);
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->enum('gender', ['male', 'female', 'prefer_not_to_say'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality', 60)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('country', 60)->default('Uzbekistan');
            $table->json('preferences')->nullable(); // notification prefs, language, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('users');
    }
};
