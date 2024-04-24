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
        Schema::create('advertisement_type_filters', function (Blueprint $table) {
            $table->foreignId('filter_id');
            $table->foreignId('advertisement_type_id');
            $table->primary(['filter_id', 'advertisement_type_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_type_filters');
    }
};
