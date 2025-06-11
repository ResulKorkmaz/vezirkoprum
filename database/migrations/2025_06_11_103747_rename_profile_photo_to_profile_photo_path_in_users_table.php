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
            // Sütun varsa yeniden adlandır
            if (Schema::hasColumn('users', 'profile_photo')) {
                $table->renameColumn('profile_photo', 'profile_photo_path');
            } else {
                // Sütun yoksa oluştur
                $table->string('profile_photo_path')->nullable()->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_photo_path')) {
                $table->renameColumn('profile_photo_path', 'profile_photo');
            }
        });
    }
};
