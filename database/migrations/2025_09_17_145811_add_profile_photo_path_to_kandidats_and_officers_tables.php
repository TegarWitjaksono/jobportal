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
        Schema::table('kandidats', function (Blueprint $table) {
            $table->string('profile_photo_path', 2048)->nullable()->after('user_id');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->string('profile_photo_path', 2048)->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path');
        });
    }
};