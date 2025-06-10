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
            $table->boolean('is_suspended')->default(false)->after('is_admin');
            $table->timestamp('suspended_until')->nullable()->after('is_suspended');
            $table->text('suspension_reason')->nullable()->after('suspended_until');
            $table->unsignedBigInteger('suspended_by')->nullable()->after('suspension_reason');
            $table->timestamp('suspended_at')->nullable()->after('suspended_by');
            $table->text('admin_notes')->nullable()->after('suspended_at');
            $table->timestamp('last_login_at')->nullable()->after('admin_notes');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            
            $table->foreign('suspended_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['suspended_by']);
            $table->dropColumn([
                'is_suspended',
                'suspended_until',
                'suspension_reason',
                'suspended_by',
                'suspended_at',
                'admin_notes',
                'last_login_at',
                'last_login_ip'
            ]);
        });
    }
};
