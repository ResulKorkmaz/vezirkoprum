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
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->text('content')->after('user_id');
            $table->string('image')->nullable()->after('content');
            $table->boolean('is_active')->default(true)->after('image');
            
            // Performans için index'ler
            $table->index(['is_active', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['is_active', 'created_at']);
            $table->dropIndex(['user_id']);
            $table->dropColumn(['user_id', 'content', 'image', 'is_active']);
        });
    }
};
