<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserStampable;
use Illuminate\Database\Eloquent\Model;

/**
 * Model perwakilan kandidat dalam sistem.
 * berisi informasi pribadi, kontak, dan kualifikasi kandidat.
 * Kandidat dapat memiliki banyak pengalaman kerja, pendidikan, dan kemampuan.
 * @author zen-master <greget103@gmail.com>
 */
class Kandidat extends Model
{
    /** @use HasFactory<\Database\Factories\KandidatFactory> */
    use HasFactory, UserStampable;

    protected $table = 'kandidats';
    protected $fillable = [
        'user_id',
        'nama_depan',
        'nama_belakang',
        'no_telpon',
        'alamat',
        'kode_pos',
        'negara',
        'no_ktp',
        'no_npwp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_perkawinan',
        'agama',
        'bmi_score',
        'blind_score',
        'no_telpon_alternatif',
        'pengalaman_kerja',
        'pendidikan',
        'kemampuan_bahasa',
        'kemampuan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d'
    ];

    /**
     * Mengembalikan relasi kandidat dengan pengguna.
     * Relasi ini menunjukkan bahwa setiap kandidat terkait dengan satu pengguna.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Kandidat>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongans()
    {
        return $this->belongsToMany(Lowongan::class, 'lamar_lowongans', 'kandidat_id', 'lowongan_id')
                    ->withPivot('iklan_lowongan') // Menyertakan data pivot
                    ->withTimestamps(); // Menyertakan timestamps jika diperlukan
    }

    /**
     * Mengambil nama lengkap kandidat.
     * Menggabungkan nama depan dan nama belakang menjadi satu string.
     * Jika nama belakang tidak ada, hanya nama depan yang dikembalikan.
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->nama_depan} {$this->nama_belakang}");
    }

    /**
     * Mengambil alamat lengkap kandidat.
     * Menggabungkan alamat, kode pos, dan negara menjadi satu string.
     * @return string
     */
    public function getFormattedAddressAttribute()
    {
        return trim("{$this->alamat}, {$this->kode_pos}, {$this->negara}");
    }

    /**
     * Check apakah kandidat sudah menyelesaikan semua tes yang diperlukan
     * @return bool
     */
    public function hasCompletedAllTests()
    {
        return $this->hasCompletedBmiTest() && $this->hasCompletedBlindTest();
    }

    /**
     * Check apakah kandidat sudah menyelesaikan BMI test
     * @return bool
     */
    public function hasCompletedBmiTest()
    {
        return !is_null($this->bmi_score);
    }

    /**
     * Check apakah kandidat sudah menyelesaikan Blind test
     * @return bool
     */
    public function hasCompletedBlindTest()
    {
        return !is_null($this->blind_score);
    }

    /**
     * Get BMI category dalam bahasa Indonesia
     * @return string|null
     */
    public function getBmiCategoryAttribute()
    {
        if (is_null($this->bmi_score)) {
            return null;
        }

        $score = (float) $this->bmi_score;
        return ($score < 18.5) ? 'Kurus' : (($score <= 24.9) ? 'Normal' : 'Gemuk');
    }

    /**
     * Get Blind test percentage
     * @return int|null
     */
    public function getBlindTestPercentageAttribute()
    {
        return $this->blind_score ? (int) $this->blind_score : null;
    }

    /**
     * Get Blind test status
     * @return string|null
     */
    public function getBlindTestStatusAttribute()
    {
        if (is_null($this->blind_score)) {
            return null;
        }

        $score = (int) $this->blind_score;
        if ($score >= 80) {
            return 'Excellent';
        } elseif ($score >= 60) {
            return 'Good';
        } elseif ($score >= 40) {
            return 'Fair';
        }
        return 'Poor';
    }
    public function lamarLowongans()
    {
        return $this->hasMany(LamarLowongan::class, 'kandidat_id');
    }
}