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
        Schema::create('spam_words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->integer('weight')->default(1); // Spam skoru ağırlığı
            $table->enum('category', ['profanity', 'scam', 'commercial', 'inappropriate'])->default('inappropriate');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['word', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spam_words');
    }
};
