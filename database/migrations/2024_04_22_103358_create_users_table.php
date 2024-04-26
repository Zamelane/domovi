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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string    ('first_name', 45);
            $table->string    ('last_name', 45);
            $table->string    ('patronymic', 45)->nullable();
            $table->string    ('login', 45)->nullable();
            $table->string    ('password', 255)->nullable();
            $table->bigInteger('phone')->unique();
            $table->boolean   ('is_passed_moderation')->nullable()->default(false);
            $table->boolean   ('is_banned')->default(false);
            $table->foreignId ('role_id')->constrained()->cascadeOnUpdate();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
