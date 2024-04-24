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
        Schema::create('ad_filter_values', function (Blueprint $table) {
            $table->foreignId('filter_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('value', 32);
            $table->primary(['filter_id', 'advertisement_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_filter_values');
    }
};
