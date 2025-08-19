<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->string('nama_tengah')->nullable()->after('nama_depan');
        });
    }

    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropColumn('nama_tengah');
        });
    }
};
