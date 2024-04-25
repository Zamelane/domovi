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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnUpdate();
            $table->text('description');
            $table->tinyInteger('start');
            $table->dateTime('create_datetime');
            $table->dateTime('update_datetime')->nullable();
            $table->boolean('is_moderation');
            $table->boolean('is_services');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
