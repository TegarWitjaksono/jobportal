<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('cbt_settings') && !Schema::hasColumn('cbt_settings', 'passing_grade')) {
            Schema::table('cbt_settings', function (Blueprint $table) {
                $table->unsignedInteger('passing_grade')->default(70)->after('test_duration');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cbt_settings') && Schema::hasColumn('cbt_settings', 'passing_grade')) {
            Schema::table('cbt_settings', function (Blueprint $table) {
                $table->dropColumn('passing_grade');
            });
        }
    }
};

