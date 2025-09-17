<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserStampable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Override Jetstream's profile photo URL accessor to support
     * multiple stored path shapes and return a valid URL.
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            $path = (string) ($this->profile_photo_path ?? '');

            // 1) Absolute URL
            if ($path && preg_match('~^https?://~i', $path)) {
                return $path;
            }

            $normalized = ltrim($path, '/');

            // 2) Already under public/storage
            if ($normalized && str_starts_with($normalized, 'storage/')) {
                return asset($normalized);
            }

            // 3) Stored on public disk
            if ($normalized && Storage::disk('public')->exists($normalized)) {
                return asset('storage/' . $normalized);
            }

            // 4) Directly under public
            if ($normalized && is_file(public_path($normalized))) {
                return asset($normalized);
            }

            // 5) Fallback avatar using full_name or user name
            $name = trim(($this->full_name ?? '') ?: (optional($this->user)->name ?? 'User'));
            return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
        });
    }
}
