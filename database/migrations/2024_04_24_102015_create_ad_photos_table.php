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
        Schema::create('ad_photos', function (Blueprint $table) {
            $table->foreignId('photo_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('value', 32);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_photos');
    }
};
