<?php

namespace App\Livewire\Officer\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ShowProfile extends Component
{
    public $user;
    public $officer;

    public $passwordForm = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public $status = null;

    public function mount(): void
    {
        $this->user = Auth::user()->load('officer');
        $this->officer = $this->user->officer;
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
