<?php

namespace App\Livewire\Lowongan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Interfaces\LowonganRepositoryInterface;
use App\Repositories\Interfaces\KategoriLowonganRepositoryInterface;

class ListWithDetail extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $selectedCategory = '';
    public $selectedLocation = '';
    public $isRemote = '';
    public $salaryRange = '';

    public $selectedJob;

    protected $lowonganRepository;
    protected $kategoriRepository;

    public function boot(
        LowonganRepositoryInterface $lowonganRepository,
        KategoriLowonganRepositoryInterface $kategoriRepository
    ) {
        $this->lowonganRepository = $lowonganRepository;
        $this->kategoriRepository = $kategoriRepository;
    }

    public function mount()
    {
        $selectedCategory = request()->query('selectedCategory');
        if ($selectedCategory) {
            $this->selectedCategory = $selectedCategory;
        }
    }

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->selectedLocation = '';
        $this->isRemote = '';
        $this->salaryRange = '';
        $this->resetPage();
    }

    public function selectJob($id)
    {
        $this->selectedJob = $this->lowonganRepository->findLowongan($id);
    }

    public function render()
    {
        $lowongans = $this->lowonganRepository->getAllWithFilters(
            $this->search,
            $this->selectedCategory,
            $this->selectedLocation,
            $this->isRemote,
            $this->salaryRange,
            5
        );

        // Pastikan base URL pagination mengarah ke halaman browse, bukan endpoint Livewire
        if (method_exists($lowongans, 'withPath')) {
            $lowongans->withPath(route('jobs.browse'));
        }


        if (!$this->selectedJob && $lowongans->count() > 0) {
            $this->selectedJob = $lowongans->first();
        }

        $locations = $this->lowonganRepository->getDistinctLocations();
        $categories = $this->kategoriRepository->getActive();
        $salaryRanges = $this->lowonganRepository->getSalaryRanges();

        return view('livewire.lowongan.list-with-detail', [
            'lowongans' => $lowongans,
            'locations' => $locations,
            'categories' => $categories,
            'salaryRanges' => $salaryRanges,
        ]);
    }
}

