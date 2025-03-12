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
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('deck_id')->constrained();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('cards_studied')->default(0);
            $table->integer('easy_count')->default(0);
            $table->integer('medium_count')->default(0);
            $table->integer('hard_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
