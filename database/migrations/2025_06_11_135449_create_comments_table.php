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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_spam')->default(false);
            $table->integer('spam_score')->default(0);
            $table->timestamp('spam_checked_at')->nullable();
            $table->json('spam_reasons')->nullable();
            $table->timestamps();
            
            // Performans için indexler
            $table->index(['post_id', 'is_active', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['is_spam', 'spam_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
