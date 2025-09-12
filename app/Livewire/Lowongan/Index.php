<?php
namespace App\Livewire\Lowongan;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\LowonganRepositoryInterface;
use App\Repositories\Interfaces\KategoriLowonganRepositoryInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $lowonganRepo;
    protected $kategoriRepo;

    public $notificationStatus;
    public $notificationMessage;

    // Filter properties
    public $statusFilter = '';
    public $kategoriFilter = '';
    public $namaPosisiFilter = '';
    public $tanggalMulaiFilter = '';
    public $tanggalAkhirFilter = '';

    public $kategoriLowonganOptions = [];

    // Modal properties
    public $showStatusModal = false;
    public $selectedLowonganId = null;
    public $statusAction = '';
    public $confirmationMessage = '';

    protected $listeners = [
        'lowonganUpdated' => 'handleUpdated',
        'lowonganDeleted' => 'handleDeleted',
    ];

    public function boot(
        LowonganRepositoryInterface $lowonganRepo,
        KategoriLowonganRepositoryInterface $kategoriRepo
    ) {
        $this->lowonganRepo = $lowonganRepo;
        $this->kategoriRepo = $kategoriRepo;
    }

    public function mount()
    {
        $this->kategoriLowonganOptions = $this->kategoriRepo->getActive();
    }

    public function updating($name, $value)
    {
        if (in_array($name, [
            'statusFilter', 'kategoriFilter', 'namaPosisiFilter',
            'tanggalMulaiFilter', 'tanggalAkhirFilter'
        ])) {
            $this->resetPage();
        }
    }

    // Tambahkan method untuk reset filter
    public function resetFilters()
    {
        $this->statusFilter = '';
        $this->kategoriFilter = '';
        $this->namaPosisiFilter = '';
        $this->tanggalMulaiFilter = '';
        $this->tanggalAkhirFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.lowongan.index', [
            'lowongans' => $this->lowonganRepo->filterPaginate(
                10,
                $this->statusFilter,
                $this->kategoriFilter,
                $this->namaPosisiFilter,
                $this->tanggalMulaiFilter,
                $this->tanggalAkhirFilter
            ),
            'kategoriLowonganOptions' => $this->kategoriRepo->getActive()
        ]);
    }

    public function openEdit($id)
    {
        return redirect()->route('Lowongan.Edit', $id);
    }

    public function openView($id)
    {
        return redirect()->route('Lowongan.view', $id);
    }

    // Open status confirmation modal
    public function confirmStatusChange($id, $action)
    {
        $this->selectedLowonganId = $id;
        $this->statusAction = $action;

        if ($action === 'archive') {
            $this->confirmationMessage = 'Apakah Anda yakin ingin mengarsipkan lowongan ini?';
        } else {
            $this->confirmationMessage = 'Apakah Anda yakin ingin memposting kembali lowongan ini?';
        }

        $this->showStatusModal = true;
    }

    // Cancel status change
    public function cancelStatusChange()
    {
        $this->resetStatusModal();
    }

    // Reset modal properties
    private function resetStatusModal()
    {
        $this->showStatusModal = false;
        $this->selectedLowonganId = null;
        $this->statusAction = '';
        $this->confirmationMessage = '';
    }

    // Process status change after confirmation
    public function processStatusChange()
    {
        if ($this->statusAction === 'archive') {
            $this->softDelete($this->selectedLowonganId);
        } else {
            $this->postLowongan($this->selectedLowonganId);
        }

        $this->resetStatusModal();
    }

    public function softDelete($id)
    {
        // Update status menjadi archived
        $result = $this->lowonganRepo->updateLowongan($id, [
            'status' => 'archived',
            'user_update' => Auth::id(),
            'updated_at' => now(),
        ]);
        if ($result) {
            $this->notificationStatus = 'success';
            $this->notificationMessage = 'Job vacancy archived.';
        } else {
            $this->notificationStatus = 'error';
            $this->notificationMessage = 'Failed to archive job vacancy.';
        }
        $this->dispatch('lowonganDeleted');
    }

    public function postLowongan($id)
    {
        // Memastikan menggunakan metode yang sama dengan softDelete untuk konsistensi
        $result = $this->lowonganRepo->updateLowongan($id, [
            'status' => 'posted',
            'user_update' => Auth::id(),
            'updated_at' => now(),
        ]);

        if ($result) {
            $this->notificationStatus = 'success';
            $this->notificationMessage = 'Job vacancy successfully posted.';
        } else {
            $this->notificationStatus = 'error';
            $this->notificationMessage = 'Failed to post job vacancy.';
        }
        $this->dispatch('lowonganUpdated');
    }

    public function handleUpdated()
    {
        $this->notificationStatus = 'success';
        $this->notificationMessage = 'Job vacancy successfully updated.';
    }

    public function handleDeleted()
    {
        $this->notificationStatus = 'success';
        $this->notificationMessage = 'Job vacancy successfully archived.';
    }

    public function exportPdf()
    {
        // Build query mirroring repository filter to get all items
        $query = \App\Models\Lowongan::query();
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->kategoriFilter) {
            $query->where('kategori_lowongan_id', $this->kategoriFilter);
        }
        if ($this->namaPosisiFilter) {
            $query->where('nama_posisi', 'like', '%' . $this->namaPosisiFilter . '%');
        }
        if ($this->tanggalMulaiFilter) {
            $query->whereDate('tanggal_posting', '>=', $this->tanggalMulaiFilter);
        }
        if ($this->tanggalAkhirFilter) {
            $query->whereDate('tanggal_berakhir', '<=', $this->tanggalAkhirFilter);
        }
        $query->with('kategoriLowongan')->latest();

        $lowongans = $query->get();

        $html = view('livewire.lowongan.pdf-export', compact('lowongans'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = 'daftar-lowongan-' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
