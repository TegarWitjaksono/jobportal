<?php

namespace App\Livewire\Kandidat\LowonganDilamar;

use App\Models\TestResult;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $testResult = null;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            // Ambil hasil tes psikotes terakhir yang sudah selesai
            $this->testResult = TestResult::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->latest('completed_at')
                ->first();
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Jika user tidak memiliki profil kandidat, kembalikan data kosong
        if (!$user || !$user->kandidat) {
            return view('livewire.kandidat.lowongan-dilamar.index', [
                'lamaranList' => new LengthAwarePaginator([], 0, 10),
                'testResult' => $this->testResult,
            ]);
        }

        // Query untuk mengambil daftar lamaran
        $query = $user->kandidat
            ->lamarLowongans()
            ->with(['lowongan', 'progressRekrutmen.officer'])
            ->when($this->search, function ($q) {
                $q->whereHas('lowongan', function ($qq) {
                    $qq->where('nama_posisi', 'like', '%' . $this->search . '%');
                });
            })
            ->latest();

        $lamaranList = $query->paginate(10);

        return view('livewire.kandidat.lowongan-dilamar.index', [
            'lamaranList' => $lamaranList,
            'testResult' => $this->testResult,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
