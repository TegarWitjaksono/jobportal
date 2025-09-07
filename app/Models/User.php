<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Kandidat;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole($role)
    {
        // Example implementation - adjust based on your actual role structure
        return $this->role === $role;
    }

    public function hasPosition($position)
    {
        return $this->hasRole('officer') &&
                $this->officer &&
                $this->officer->jabatan === $position;
    }

    // Tambahkan relasi officer untuk mengakses jabatan officer
    public function officer()
    {
        return $this->hasOne(\App\Models\Officer::class, 'user_id');
    }

    public function kandidat()
    {
        return $this->hasOne(Kandidat::class, 'user_id');
    }

    // Accessor: normalized role (lowercase)
    public function getNormalizedRoleAttribute(): string
    {
        return strtolower($this->role ?? '');
    }

    // Accessor: whether user is kandidat
    public function getIsKandidatAttribute(): bool
    {
        return $this->normalized_role === 'kandidat';
    }

    // Accessor: whether user is officer
    public function getIsOfficerAttribute(): bool
    {
        return $this->normalized_role === 'officer';
    }

    // Accessor: role badge label, e.g. "Kandidat" or "Officer (Manager)"
    public function getRoleBadgeLabelAttribute(): string
    {
        if ($this->is_officer) {
            $jabatan = optional($this->officer)->jabatan;
            $formatted = $jabatan ? ' (' . ucfirst(strtolower($jabatan)) . ')' : '';
            return 'Officer' . $formatted;
        }

        if ($this->is_kandidat) {
            return 'Kandidat';
        }

        return ucfirst($this->normalized_role ?: 'User');
    }

    // Accessor: role badge class for styling
    public function getRoleBadgeClassAttribute(): string
    {
        if ($this->is_officer) return 'bg-soft-warning text-warning';
        if ($this->is_kandidat) return 'bg-soft-success text-success';
        return 'bg-soft-secondary text-muted';
    }
}
