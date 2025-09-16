<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE progress_rekrutmen MODIFY COLUMN status ENUM('screening','interview','psikotes','diterima','ditolak') NOT NULL DEFAULT 'interview'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE progress_rekrutmen MODIFY COLUMN status ENUM('diterima','interview','psikotes','ditolak') NOT NULL DEFAULT 'interview'");
    }
};
