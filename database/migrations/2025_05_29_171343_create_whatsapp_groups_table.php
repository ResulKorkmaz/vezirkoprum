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
        Schema::create('whatsapp_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('district')->nullable();
            $table->text('description')->nullable();
            $table->string('invite_link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Performans için index'ler
            $table->index(['city', 'is_active']);
            $table->index(['district', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_groups');
    }
};
