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
        // TODO: вынести мб в .env ?
        $filter_types = [
            'select',
            'write_text',
            'write_number'
        ];

        Schema::create('filters', function (Blueprint $table) use ($filter_types) {
            $table->id();
            $table->string('name', 255);
            $table->enum('type', $filter_types);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
