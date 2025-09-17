<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserStampable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Officer extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
    use HasFactory, UserStampable, HasProfilePhoto;

    protected $fillable = [
        'user_id',
        'profile_photo_path',
        'nama_depan',
        'nama_belakang',
        'nik',
        'jabatan',
        'atasan_id',
        'doh',
        'lokasi_penugasan',
        'area',
        'is_active',
    ];

    protected $casts = [
        'doh' => 'date',
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
        'atasan_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Relasi antara Officer dan User.
     * Setiap officer terkait dengan satu user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Officer>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi antara Officer dan Atasan.
     * Setiap officer terkait dengan satu atasan.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Officer, Officer>
     */
    public function atasan()
    {
        return $this->belongsTo(Officer::class, 'atasan_id');
    }

    /**
     * Relasi antara Officer dan Bawahan.
     * Setiap officer dapat memiliki banyak bawahan.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Officer>
     */
    public function bawahan()
    {
        return $this->hasMany(Officer::class, 'atasan_id');
    }

    public function progressRekrutmen()
    {
        return $this->hasMany(ProgressRekrutmen::class, 'officer_id');
    }

    /**
     * Mengambil nama lengkap officer.
     * Menggabungkan nama depan dan nama belakang menjadi satu string.
     * Jika nama belakang tidak ada, hanya nama depan yang dikembalikan.
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->nama_depan} {$this->nama_belakang}");
    }

    /**
     * Mengambil lokasi penugasan lengkap officer.
     * Menggabungkan lokasi penugasan dan area menjadi satu string.
     * @return string
     */
    public function getFormattedLocationAttribute()
    {
        return trim("{$this->lokasi_penugasan}, {$this->area}");
    }

}
