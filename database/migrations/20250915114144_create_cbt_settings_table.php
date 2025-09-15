<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cbt_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('max_questions')->default(25);
            $table->unsignedInteger('test_duration')->default(30); // minutes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbt_settings');
    }
};
