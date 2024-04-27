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
        $transaction_types = [
            'order',
            'buy'
        ];

        $measurement_types = [
            'ar',
            'm2'
        ];

        Schema::create('advertisements', function (Blueprint $table) use(
            $transaction_types,
            $measurement_types
        ) {
            $table->id();
            $table->foreignId  ('user_id'                             )               ->constrained()->cascadeOnUpdate();
            $table->foreignId  ('advertisement_id'                    )->nullable()   ->constrained()->cascadeOnUpdate();
            $table->foreignId  ('address_id'                          )               ->constrained()->cascadeOnUpdate();
            $table->foreignId  ('advertisement_type_id'               )               ->constrained()->cascadeOnUpdate();
            $table->enum       ('transaction_type', $transaction_types);
            $table->integer    ('area'                                );
            $table->tinyInteger('count_rooms'                         )->nullable();
            $table->enum       ('measurement_type', $measurement_types);
            $table->boolean    ('is_active'                           )            ->default(false);
            $table->boolean    ('is_moderated'                        )->nullable()->default(null);
            $table->boolean    ('is_deleted'                          )->default(false);
            $table->boolean    ('is_archive'                          )->default(false);
            $table->decimal    ('cost', 16                        );
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
