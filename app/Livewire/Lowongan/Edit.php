<?php
namespace App\Livewire\Lowongan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\LowonganRepositoryInterface;
use App\Repositories\Interfaces\KategoriLowonganRepositoryInterface;

class Edit extends Component
{
    use WithFileUploads;

    public $lowongan;
    public $kategori_lowongan_id;
    public $nama_posisi;
    public $departemen;
    public $lokasi_penugasan;
    public $is_remote;
    public $tanggal_posting;
    public $tanggal_berakhir;
    public $foto;
    public $oldFoto;
    public $deskripsi;
    public $range_gaji;
    public $kemampuan_yang_dibutuhkan;
    public $kategoriLowonganOptions = [];

    public $notificationStatus;
    public $notificationMessage;

    protected $lowonganRepo;
    protected $kategoriRepo;

    public function boot(
        LowonganRepositoryInterface $lowonganRepo,
        KategoriLowonganRepositoryInterface $kategoriRepo
    ){
        $this->lowonganRepo = $lowonganRepo;
        $this->kategoriRepo = $kategoriRepo;
    }

    public function mount($id)
    {
        $this->lowongan = $this->lowonganRepo->findLowongan($id);
        $this->kategori_lowongan_id = $this->lowongan->kategori_lowongan_id;
        $this->nama_posisi = $this->lowongan->nama_posisi;
        $this->departemen = $this->lowongan->departemen;
        $this->lokasi_penugasan = $this->lowongan->lokasi_penugasan;
        $this->is_remote = (int) $this->lowongan->is_remote;
        $this->tanggal_posting = optional($this->lowongan->tanggal_posting)->format('Y-m-d');
        $this->tanggal_berakhir = optional($this->lowongan->tanggal_berakhir)->format('Y-m-d');
        $this->oldFoto = $this->lowongan->foto;
        $this->deskripsi = $this->lowongan->deskripsi;
        $this->range_gaji = $this->lowongan->range_gaji;
        $this->kemampuan_yang_dibutuhkan = $this->lowongan->kemampuan_yang_dibutuhkan;
        $this->kategoriLowonganOptions = $this->kategoriRepo->getActive();
    }

    public function rules()
    {
        return [
            'kategori_lowongan_id' => 'required|integer',
            'nama_posisi' => 'required|string',
            'departemen' => 'required|string',
            'lokasi_penugasan' => 'required|string',
            'is_remote' => 'boolean',
            'tanggal_posting' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_posting',
            'foto' => 'nullable|image|max:2048',
            'deskripsi' => 'required|string',
            'range_gaji' => 'nullable|string',
            'kemampuan_yang_dibutuhkan' => 'nullable|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $fotoFilename = $this->oldFoto;
        if ($this->foto) {
            $fotoFilename = $this->foto->store('image/lowongan', 'public');
            $fotoFilename = basename($fotoFilename);
            // Hapus foto lama jika ada
            if ($this->oldFoto && file_exists(public_path('storage/image/lowongan/' . $this->oldFoto))) {
                @unlink(public_path('storage/image/lowongan/' . $this->oldFoto));
            }
        }

        $result = $this->lowonganRepo->updateLowongan($this->lowongan->id, [
            'kategori_lowongan_id' => $this->kategori_lowongan_id,
            'nama_posisi' => $this->nama_posisi,
            'departemen' => $this->departemen,
            'lokasi_penugasan' => $this->lokasi_penugasan,
            'is_remote' => $this->is_remote,
            'tanggal_posting' => $this->tanggal_posting,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'foto' => $fotoFilename,
            'deskripsi' => $this->deskripsi,
            'range_gaji' => $this->range_gaji,
            'kemampuan_yang_dibutuhkan' => $this->kemampuan_yang_dibutuhkan,
            'user_update' => Auth::id(),
            'updated_at' => now(),
        ]);

        if ($result) {
            $this->notificationStatus = 'success';
            $this->notificationMessage = 'Lowongan berhasil diubah.';
        } else {
            $this->notificationStatus = 'error';
            $this->notificationMessage = 'Lowongan gagal diubah.';
        }
        $this->dispatch('lowonganUpdated');
        return redirect()->route('Lowongan.Index');
    }

    public function render()
    {
        return view('livewire.Lowongan.edit');
    }
}
