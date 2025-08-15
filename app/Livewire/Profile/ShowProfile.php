<?php

namespace App\Livewire\Profile;

use App\Models\Kandidat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowProfile extends Component
{
    public $kandidat;

    public function mount()
    {
        // Mengambil data user yang sedang login beserta relasi 'kandidat'
        $user = Auth::user()->load('kandidat');
        $this->kandidat = $user->kandidat;
    }

    public function render()
    {
        // Memberitahu Livewire untuk menggunakan layout utama 'layouts.app'
        return view('livewire.profile.show-profile');
    }
}