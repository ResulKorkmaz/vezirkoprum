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
            $table->string('unique_user_id', 10)->unique()->after('id')->nullable();
            $table->index('unique_user_id');
        });
        
        // Mevcut kullanıcılara unique_user_id ata
        $this->assignUniqueUserIds();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['unique_user_id']);
            $table->dropColumn('unique_user_id');
        });
    }
    
    /**
     * Mevcut kullanıcılara unique_user_id ata
     */
    private function assignUniqueUserIds(): void
    {
        $users = \App\Models\User::whereNull('unique_user_id')->get();
        $startId = 55900;
        
        foreach ($users as $user) {
            // Benzersiz ID bul
            do {
                $uniqueId = (string) $startId;
                $exists = \App\Models\User::where('unique_user_id', $uniqueId)->exists();
                $startId++;
            } while ($exists);
            
            $user->update(['unique_user_id' => $uniqueId]);
        }
    }
};
