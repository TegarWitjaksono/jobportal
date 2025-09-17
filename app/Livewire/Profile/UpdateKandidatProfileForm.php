<?php

namespace App\Livewire\Profile;

use App\Models\Kandidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Component;

class UpdateKandidatProfileForm extends Component
{
    use WithFileUploads;

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
     * The authenticated user instance.
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * Holds the uploaded profile photo before it is saved.
     *
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $photo = null;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user()->load('kandidat');
        $this->kandidat = $this->user->kandidat;

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
                'riwayat_pengalaman_kerja' => '',
                'riwayat_pendidikan' => '',
                'kemampuan_bahasa' => '',
                'informasi_spesifik' => '',
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
            'state.pendidikan' => ['nullable', 'string'],
            'state.riwayat_pengalaman_kerja' => ['nullable', 'string'],
            'state.riwayat_pendidikan' => ['nullable', 'string'],
            'state.kemampuan_bahasa' => ['nullable', 'string'],
            'state.informasi_spesifik' => ['nullable', 'string'],
            'state.kemampuan' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Tentukan pendidikan tertinggi secara otomatis dari riwayat pendidikan
        $educationHistory = json_decode($validatedData['state']['riwayat_pendidikan'] ?? '[]', true);
        if (is_array($educationHistory) && !empty($educationHistory)) {
            $levels = [
                'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3', 'Post Doktoral'
            ];
            $highest = null;
            $currentMax = -1;
            foreach ($educationHistory as $edu) {
                $index = array_search($edu['level'] ?? '', $levels, true);
                if ($index !== false && $index > $currentMax) {
                    $currentMax = $index;
                    $highest = $edu['level'];
                }
            }
            $validatedData['state']['pendidikan'] = $highest;
        } else {
            $validatedData['state']['pendidikan'] = null;
        }

        // Gunakan updateOrCreate untuk membuat profil jika belum ada, atau memperbarui jika sudah ada
        Kandidat::updateOrCreate(
            ['user_id' => $user->id],
            $validatedData['state']
        );

        if ($this->photo) {
            $user->updateProfilePhoto($this->photo);
            $this->photo = null;
        }

        $this->user->refresh();

        // Beri feedback ke pengguna
        $this->dispatch('saved');

        session()->flash('success', 'Profil kandidat berhasil diperbarui.');

        return redirect()->route('profile.show');
    }

    /**
     * Remove the current profile photo for the authenticated user.
     */
    public function removeProfilePhoto(): void
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            $user->deleteProfilePhoto();
            $this->user->refresh();
            session()->flash('success', 'Foto profil berhasil dihapus.');
        }

        $this->photo = null;
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