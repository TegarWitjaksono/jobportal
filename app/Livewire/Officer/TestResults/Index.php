<?php

namespace App\Livewire\Officer\TestResults;

use Livewire\Component;
use App\Models\TestResult;
use Livewire\WithPagination;
use Dompdf\Dompdf;
use Dompdf\Options;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Detail modal state
    public $detailModal = false;
    public $detailResult; // Holds TestResult model instance

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

    public function openDetail($resultId)
    {
        $this->detailResult = TestResult::with('user')->findOrFail($resultId);
        $this->detailModal = true;
    }

    public function closeDetail()
    {
        $this->detailModal = false;
        $this->detailResult = null;
    }

    /**
     * Export ringkasan detail (isi modal) ke PDF untuk satu hasil.
     */
    public function exportDetail($id)
    {
        $result = TestResult::with('user')->findOrFail($id);

        $html = view('livewire.officer.test-results.pdf-detail', [
            'result' => $result,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'detail-hasil-psikotes-' . ($result->user->name ?? 'kandidat') . '-' . now()->format('Ymd_His') . '.pdf';

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
