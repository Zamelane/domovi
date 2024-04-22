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
            $table->string   ('first_name', 45);
            $table->string   ('last_name', 45);
            $table->string   ('patronymic', 45);
            $table->boolean  ('is_passed_moderation');
            $table->boolean  ('is_banned');
            $table->foreignId('phone_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('role_id')->constrained()->cascadeOnUpdate();
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
