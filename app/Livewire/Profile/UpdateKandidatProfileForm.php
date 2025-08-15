<?php

namespace App\Livewire\Profile;

use App\Models\Kandidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateKandidatProfileForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The kandidat model instance.
     *
     * @var \App\Models\Kandidat
     */
    public $kandidat;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $user = Auth::user()->load('kandidat');
        $this->kandidat = $user->kandidat;

        if ($this->kandidat) {
            // Jika kandidat sudah ada, muat datanya
            $this->state = $this->kandidat->toArray();

            // PERBAIKAN: Ubah format tanggal agar sesuai dengan input HTML
            if (isset($this->state['tanggal_lahir'])) {
                $this->state['tanggal_lahir'] = \Carbon\Carbon::parse($this->state['tanggal_lahir'])->setTimezone(config('app.timezone'))->format('Y-m-d');
            }
        } else {
            // Jika kandidat belum ada, siapkan state dengan data kosong
            $this->state = [
                'nama_depan' => '',
                'nama_belakang' => '',
                'no_telpon' => '',
                'no_telpon_alternatif' => '',
                'alamat' => '',
                'kode_pos' => '',
                'negara' => 'Indonesia',
                'no_ktp' => '',
                'no_npwp' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => '',
                'jenis_kelamin' => '',
                'status_perkawinan' => '',
                'agama' => '',
                'pendidikan' => '',
                'pengalaman_kerja' => '',
                'kemampuan_bahasa' => '',
                'kemampuan' => '',
            ];
        }
    }

    /**
     * Update the user's kandidat profile information.
     *
     * @return void
     */
    public function updateKandidatProfile()
    {
        $user = Auth::user();

        $validatedData = $this->validate([
            'state.nama_depan' => ['required', 'string', 'max:255'],
            'state.nama_belakang' => ['required', 'string', 'max:255'],
            'state.no_telpon' => ['required', 'string', 'max:20'],
            'state.no_telpon_alternatif' => ['nullable', 'string', 'max:20'],
            'state.alamat' => ['required', 'string'],
            'state.kode_pos' => ['required', 'string', 'max:10'],
            'state.negara' => ['required', 'string', 'max:100'],
            'state.no_ktp' => ['required', 'string', 'max:20', Rule::unique('kandidats', 'no_ktp')->ignore($user->kandidat->id ?? null)],
            'state.no_npwp' => ['nullable', 'string', 'max:25'],
            'state.tempat_lahir' => ['required', 'string', 'max:100'],
            'state.tanggal_lahir' => ['required', 'date'],
            'state.jenis_kelamin' => ['required', 'in:L,P'],
            'state.status_perkawinan' => ['required', 'string', 'max:50'],
            'state.agama' => ['required', 'string', 'max:50'],
            'state.pendidikan' => ['required', 'string'],
            'state.pengalaman_kerja' => ['nullable', 'string'],
            'state.kemampuan_bahasa' => ['nullable', 'string'],
            'state.kemampuan' => ['nullable', 'string'],
        ]);

        // Gunakan updateOrCreate untuk membuat profil jika belum ada, atau memperbarui jika sudah ada
        Kandidat::updateOrCreate(
            ['user_id' => $user->id],
            $validatedData['state']
        );

        // Beri feedback ke pengguna
        $this->dispatch('saved');

        // Refresh state jika diperlukan (opsional, tergantung UX)
        // $this->state = $user->fresh()->kandidat->toArray();

        // Bisa juga dengan flash message jika halaman direfresh
        session()->flash('status', 'Profil kandidat berhasil diperbarui.');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.profile.update-kandidat-profile-form');
    }
}