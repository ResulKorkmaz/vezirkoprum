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
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_spam')->default(false);
            $table->integer('spam_score')->default(0);
            $table->enum('spam_status', ['clean', 'suspicious', 'spam', 'quarantined'])->default('clean');
            $table->timestamp('spam_checked_at')->nullable();
            $table->json('spam_reasons')->nullable(); // Spam nedenlerini JSON olarak saklayacağız
            
            $table->index(['is_spam', 'spam_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'is_spam',
                'spam_score', 
                'spam_status',
                'spam_checked_at',
                'spam_reasons'
            ]);
        });
    }
};
