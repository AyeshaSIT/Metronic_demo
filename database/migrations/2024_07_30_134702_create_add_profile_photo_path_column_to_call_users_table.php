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
        Schema::table('call_user', function (Blueprint $table) {
            $table->string('profile_photo_path', 2048)->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('add_profile_photo_path_column_to_call_users');
        Schema::table('call_user', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path');
        });
    }
};
