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
            // Existing fields
            $table->string('role')->default('renter'); // 'admin', 'owner', 'renter'
            $table->boolean('is_verified')->default(false);

            // ✅ Newly added fields for owner registration
            $table->string('phone')->nullable();
            $table->string('valid_id')->nullable();

            // ✅ Added address field for owner location restriction
            $table->string('address')->nullable();

            // ✅ Added Veriff session ID for ID verification tracking
            $table->string('veriff_session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'valid_id')) {
                $table->dropColumn('valid_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'veriff_session_id')) {
                $table->dropColumn('veriff_session_id');
            }
        });
    }
};
