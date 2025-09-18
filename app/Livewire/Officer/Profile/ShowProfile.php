<?php

namespace App\Livewire\Officer\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $officer;

    public $passwordForm = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public $status = null;

    /**
     * Temporary uploaded photo for officer profile.
     *
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $photo = null;

    public function mount(): void
    {
        $this->user = Auth::user()->load('officer');
        $this->officer = $this->user->officer;
    }

    public function saveProfilePhoto(): void
    {
        if (! $this->officer) {
            $this->addError('photo', __('Profil officer belum tersedia.'));
            return;
        }

        if (! $this->photo) {
            $this->addError('photo', __('Silakan pilih foto profil terlebih dahulu.'));
            return;
        }

        $this->validate([
            'photo' => ['image', 'max:2048'],
        ]);

        $this->officer->updateProfilePhoto($this->photo);
        $this->officer->refresh();
        $this->photo = null;

        session()->flash('status', __('Foto profil berhasil diperbarui.'));
    }

    public function removeProfilePhoto(): void
    {
        // For Officer
        if ($this->officer && $this->officer->profile_photo_path) {
            Storage::disk('public')->delete($this->officer->profile_photo_path);
            $this->officer->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }

        // For User
        if ($this->user && $this->user->profile_photo_path) {
            Storage::disk('public')->delete($this->user->profile_photo_path);
            $this->user->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }

        // Refresh the main user model, which will cascade to the officer relation
        $this->user->refresh();
        $this->officer = $this->user->officer;

        $this->photo = null;

        session()->flash('status', __('Foto profil berhasil dihapus.'));
    }

    public function updatePassword(): void
    {
        $validated = $this->validate(
            [
                'passwordForm.current_password' => ['required', 'current_password'],
                'passwordForm.password' => ['required', 'string', Password::defaults(), 'confirmed'],
                'passwordForm.password_confirmation' => ['required'],
            ],
            [],
            [
                'passwordForm.current_password' => __('current password'),
                'passwordForm.password' => __('password'),
                'passwordForm.password_confirmation' => __('password confirmation'),
            ]
        );

        $this->user->forceFill([
            'password' => Hash::make($validated['passwordForm']['password']),
        ])->save();

        $this->passwordForm = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->status = 'password-updated';
        session()->flash('status', __('Password berhasil diperbarui.'));
    }

    public function render()
    {
        return view('livewire.officer.profile.show-profile');
    }
}