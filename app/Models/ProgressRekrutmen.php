<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressRekrutmen extends Model
{
    /** @use HasFactory<\Database\Factories\ProgressRekrutmenFactory> */
    use HasFactory;

    protected $table = 'progress_rekrutmen';

    protected $fillable = [
        'lamar_lowongan_id',
        'officer_id',
        'nama_progress',
        'status',
        'catatan',
        'dokumen_pendukung',
        'is_interview',
        'is_psikotes',
        'waktu_pelaksanaan',
        'waktu_selesai',
        'user_create',
        'link_zoom', // Tambahkan ini
    ];

    protected $casts = [
        'waktu_pelaksanaan' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_interview' => 'boolean',
        'is_psikotes' => 'boolean',
    ];

    // Daftar status yang diizinkan
    public static $allowedStatuses = [
        'diterima',
        'interview',
        'psikotes',
        'ditolak'
    ];

    public function lamarlowongan()
    {
        return $this->belongsTo(LamarLowongan::class, 'lamar_lowongan_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function interview()
    {
        return $this->hasOne(Interview::class, 'progress_rekrutmen_id');
    }
}
