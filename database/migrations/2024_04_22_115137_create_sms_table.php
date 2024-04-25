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
            $table->string      ('token', 25)->primary();
            $table->string      ('code', 6)->nullable();
            $table->string      ('ip', 15);
            $table->bigInteger  ('phone');
            $table->tinyInteger ('attempts');
            $table->dateTime    ('datetime_sending')->useCurrent();
            // $table->timestamps();
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
