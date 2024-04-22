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
        Schema::create('sms', function (Blueprint $table) {
            $table->string('token', 25)->primary();
            $table->string('code', 6);
            $table->string('ip', 15);
            $table->tinyInteger('attempts');
            $table->dateTime('datetime_sending');
            $table->foreignId('phone_id')->constrained()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smses');
    }
};
