<?php

namespace App\Livewire\Officer\TestResults;

use Livewire\Component;
use App\Models\TestResult;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = TestResult::with(['user'])
        ->when($this->search, function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        });

        $totalPeserta = (clone $query)->count();
        $lulus = (clone $query)->where('score', '>=', 70)->count();
        $tidakLulus = (clone $query)->where('score', '<', 70)->count();
        $rataRataSkor = (clone $query)->avg('score');

        // 3. Terapkan sorting ke query utama
        if ($this->sortField === 'user_name') {
            $resultsQuery = $query->join('users', 'test_results.user_id', '=', 'users.id')
                            ->select('test_results.*')
                            ->orderBy('users.name', $this->sortDirection);
        } else {
            $resultsQuery = $query->orderBy($this->sortField, $this->sortDirection);
        }
        
        // 4. Lakukan paginasi HANYA untuk data yang akan ditampilkan di tabel
        $results = $resultsQuery->paginate(10);

        // 5. Kirim semua data (statistik dan hasil paginasi) ke view
        return view('livewire.officer.test-results.index', [
            'results' => $results,
            'totalPeserta' => $totalPeserta,
            'lulus' => $lulus,
            'tidakLulus' => $tidakLulus,
            'rataRataSkor' => $rataRataSkor,
        ]);
    }
}