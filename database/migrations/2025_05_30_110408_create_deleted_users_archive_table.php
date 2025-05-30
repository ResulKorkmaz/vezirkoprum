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
        Schema::create('deleted_users_archive', function (Blueprint $table) {
            $table->id();
            $table->string('unique_user_id', 10)->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_district')->nullable();
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('show_phone')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('original_created_at');
            $table->timestamp('deleted_at');
            $table->text('deletion_reason')->nullable();
            $table->string('deleted_by_ip')->nullable();
            $table->text('compressed_data'); // Sıkıştırılmış JSON verisi
            $table->timestamps();
            
            // İndeksler
            $table->index(['unique_user_id', 'deleted_at']);
            $table->index('email');
            $table->index('phone');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_users_archive');
    }
};
