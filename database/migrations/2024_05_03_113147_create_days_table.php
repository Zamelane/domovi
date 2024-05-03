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
        Schema::create('days', function (Blueprint $table) {
            $table->enum('code', ['monday', "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]);
            $table->foreignId('office_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->time('open_time');
            $table->time('close_time');
            $table->primary(['code', 'office_id']);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};
