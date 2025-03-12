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
        Schema::create('card_progress', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('card_id')->constrained()->onDelete('cascade');
            $table->foreignId('study_session_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('familiarity_level')->default(0);
            $table->date('next_review_date');
            $table->integer('review_count')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_progress');
    }
};
