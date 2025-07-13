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
        Schema::create('lamar_lowongans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kandidat_id')->constrained()->onDelete('cascade');
            $table->string('iklan_lowongan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamar_lowongans');
    }
};
