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
        Schema::create('banned_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone_hash', 255)->nullable(); // Şifreli telefon numarasının hash'i
            $table->string('ban_type')->default('permanent'); // permanent, temporary
            $table->text('ban_reason');
            $table->unsignedBigInteger('banned_by');
            $table->timestamp('banned_at');
            $table->timestamp('ban_expires_at')->nullable();
            $table->json('original_user_data')->nullable(); // Orijinal kullanıcı verilerinin yedegi
            $table->timestamps();
            
            $table->foreign('banned_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('email');
            $table->index('phone_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_users');
    }
};
