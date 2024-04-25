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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('deal_status_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnUpdate();
            $table->tinyInteger('percent')->default(5);
            $table->date('create_date');
            $table->date('start_date')->nullable();
            $table->date('valid_until_date')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
