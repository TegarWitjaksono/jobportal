<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progress_rekrutmen', function (Blueprint $table) {
            $table->timestamp('waktu_selesai')->nullable()->after('waktu_pelaksanaan');
        });
    }

    public function down(): void
    {
        Schema::table('progress_rekrutmen', function (Blueprint $table) {
            $table->dropColumn('waktu_selesai');
        });
    }
};

