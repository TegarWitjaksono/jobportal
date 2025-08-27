<?php
namespace App\Livewire\KategoriLowongan;

use Livewire\Component;
use App\Models\KategoriLowongan;
use App\Repositories\Interfaces\KategoriLowonganRepositoryInterface;
use Dompdf\Dompdf;   // <-- Impor Dompdf
use Dompdf\Options; // <-- Impor Options

class Index extends Component
{
    public $kategoriLowongans;
    protected $kategoriRepo;
    public $notificationStatus;
    public $notificationMessage;


    protected $listeners = [
        'kategoriLowonganUpdated' => '$refresh',
        'kategoriLowonganDeleted' => '$refresh',
        'kategoriLowonganUpdated' => 'handleKategoriLowonganUpdated',
        'kategoriLowonganDeleted' => 'handleKategoriLowonganDeleted',
    ];

    public function boot(KategoriLowonganRepositoryInterface $kategoriRepo)
    {
        $this->kategoriRepo = $kategoriRepo;
    }

    public function mount()
    {
        $this->kategoriLowongans = $this->kategoriRepo->getActive();
    }

    public function render()
    {
        $this->kategoriLowongans = $this->kategoriRepo->getActive();
        return view('livewire.kategori-lowongan.index');
    }

    /**
     * Fungsi baru untuk membuat dan mengunduh file PDF.
     */
    public function exportPdf()
    {
        // Ambil semua data aktif dari repository
        $kategoriLowongans = $this->kategoriRepo->getActive();

        // Render view template PDF menjadi HTML
        $html = view('livewire.kategori-lowongan.pdf-export', compact('kategoriLowongans'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Penting agar base64 image berfungsi

        // Buat instance Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Buat nama file yang dinamis
        $fileName = 'daftar-kategori-lowongan-' . now()->format('Y-m-d') . '.pdf';

        // Kirim response agar browser mengunduh file PDF
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }

    public function openEditModal($id)
    {
        $this->dispatch('editKategoriLowongan', $id);
    }

    public function openDeleteModal($id)
    {
        $this->dispatch('deleteKategoriLowongan', $id);
    }

    public function handleKategoriLowonganUpdated()
    {
        $this->notificationStatus = 'success';
        $this->notificationMessage = 'Category successfully saved or updated.';
    }

    public function handleKategoriLowonganDeleted()
    {
        $this->notificationStatus = 'success';
        $this->notificationMessage = 'Category successfully deactivated.';
    }
}