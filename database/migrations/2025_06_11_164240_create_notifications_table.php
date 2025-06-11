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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Bildirim alan kullanıcı
            $table->foreignId('from_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Bildirimi gönderen kullanıcı
            $table->string('type'); // 'message', 'like', 'comment', 'follow', etc.
            $table->string('title'); // Bildirim başlığı
            $table->text('message'); // Bildirim mesajı
            $table->string('notifiable_type')->nullable(); // Polymorphic - Post, Comment, Message, vb.
            $table->unsignedBigInteger('notifiable_id')->nullable(); // Polymorphic ID
            $table->json('data')->nullable(); // Ek veriler (user avatars, counts, vb.)
            $table->boolean('is_read')->default(false); // Okundu mu?
            $table->timestamp('read_at')->nullable(); // Ne zaman okundu?
            $table->boolean('is_email_sent')->default(false); // E-posta gönderildi mi?
            $table->timestamp('email_sent_at')->nullable(); // E-posta ne zaman gönderildi?
            $table->string('action_url')->nullable(); // Tıklanınca nereye gidecek?
            $table->timestamps();
            
            // Indexler
            $table->index(['user_id', 'is_read', 'created_at']);
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index(['type', 'created_at']);
            $table->index(['from_user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
