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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('profession_id')->nullable()->constrained()->onDelete('set null');
            $table->string('current_city')->nullable();
            $table->string('current_district')->nullable();
            $table->text('phone')->nullable(); // AES-256 şifreli
            $table->boolean('show_phone')->default(false);
            $table->year('birth_year')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_admin')->default(false);
            
            // Performans için index'ler
            $table->index('current_city');
            $table->index('current_district');
            $table->index('profession_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profession_id']);
            $table->dropIndex(['current_city']);
            $table->dropIndex(['current_district']);
            $table->dropIndex(['profession_id']);
            $table->dropColumn([
                'profession_id',
                'current_city',
                'current_district',
                'phone',
                'show_phone',
                'birth_year',
                'bio',
                'is_admin'
            ]);
        });
    }
};
