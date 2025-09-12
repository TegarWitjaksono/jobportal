<?php
namespace App\Livewire\Officer;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Officer;
use App\Repositories\Interfaces\OfficerRepositoryInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $officerRepository;

    public $notificationStatus = null;
    public $notificationMessage = '';

    // Search and filter properties
    public $search = '';
    public $jabatanFilter = '';
    public $lokasiFilter = '';

    // Pagination and sorting
    public $perPage = 10;
    public $sortField = 'nama_depan';
    public $sortDirection = 'asc';

    // Listen for the officer created event form modal
    protected $listeners = [
        'officerCreated' => '$refresh',
        'showNotification' => 'handleNotification'
    ];

    public function boot(OfficerRepositoryInterface $officerRepository)
    {
        $this->officerRepository = $officerRepository;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJabatanFilter()
    {
        $this->resetPage();
    }

    public function updatingLokasiFilter()
    {
        $this->resetPage();
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->search = '';
        $this->jabatanFilter = '';
        $this->lokasiFilter = '';
        $this->resetPage();
    }

    public function applyFilters()
    {
        // This will cause the component to re-render with the new filter values
        $this->resetPage(); // Reset pagination when applying new filters
    }

    public function openCreateModal()
    {
        $this->dispatch('showModal');
    }

    public function openEditModal($officerId)
    {
        $this->dispatch('editOfficer', $officerId);
    }

    public function openDeleteModal($officerId)
    {
        $this->dispatch('deleteOfficer', $officerId);
    }

    public function handleNotification($data)
    {
        $this->notificationStatus = $data['status'];
        $this->notificationMessage = $data['message'];

    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'jabatan' => $this->jabatanFilter,
            'lokasi' => $this->lokasiFilter
        ];

        $officers = $this->officerRepository->getAllOfficers(
            $filters,
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        // Get unique values for filter dropdowns
        $positions = $this->officerRepository->getUniquePositions();
        $locations = $this->officerRepository->getUniqueLocations();

        return view('livewire.officer.index', [
            'officers' => $officers,
            'positions' => $positions,
            'locations' => $locations
        ]);
    }

    public function exportPdf()
    {
        // Build filtered query similar to repository but unpaginated
        $filters = [
            'search' => $this->search,
            'jabatan' => $this->jabatanFilter,
            'lokasi' => $this->lokasiFilter,
        ];

        $query = Officer::query()->where('is_active', true);
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_depan', 'like', "%{$search}%")
                  ->orWhere('nama_belakang', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('lokasi_penugasan', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['jabatan'])) {
            $query->where('jabatan', $filters['jabatan']);
        }
        if (!empty($filters['lokasi'])) {
            $query->where('lokasi_penugasan', $filters['lokasi']);
        }

        // Sorting follow current selection
        if ($this->sortField === 'nama_lengkap') {
            $query->orderBy('nama_depan', $this->sortDirection)
                  ->orderBy('nama_belakang', $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $officers = $query->get();

        $html = view('livewire.officer.pdf-export', compact('officers'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = 'daftar-officer-' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
