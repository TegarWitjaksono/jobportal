<?php
namespace App\Livewire\KategoriLowongan;

use Livewire\Component;
use App\Models\KategoriLowongan;
use App\Repositories\Interfaces\KategoriLowonganRepositoryInterface;

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
