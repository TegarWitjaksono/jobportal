<?php

namespace App\Livewire\Cbt;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TestResult;

class Dashboard extends Component
{
    public $lamarans;
    public $search = '';

    public function mount()
    {
        $user = Auth::user();
        $kandidat = $user->kandidat ?? null;

        $this->lamarans = collect();

        if ($kandidat) {
            $this->lamarans = $kandidat->lamarLowongans()
                ->whereHas('progressRekrutmen', function ($q) {
                    $q->where('status', 'psikotes')
                      ->where('is_psikotes', true);
                })
                ->with(['lowongan', 'progressRekrutmen'])
                ->latest()
                ->get();
        }
    }

    public function render()
    {
        $query = strtolower($this->search);
        $filtered = $this->lamarans->filter(function ($lamaran) use ($query) {
            if ($query === '') return true;
            $l = $lamaran->lowongan;
            return str_contains(strtolower($l->nama_posisi ?? ''), $query)
                || str_contains(strtolower($l->departemen ?? ''), $query)
                || str_contains(strtolower($l->lokasi_penugasan ?? ''), $query);
        });

        $userId = Auth::id();
        $ongoingTest = $userId ? TestResult::where('user_id', $userId)->whereNull('completed_at')->exists() : false;
        $hasCompleted = $userId ? TestResult::where('user_id', $userId)->whereNotNull('completed_at')->exists() : false;

        return view('livewire.cbt.dashboard', [
            'lamarans' => $filtered,
            'total' => $filtered->count(),
            'ongoingTest' => $ongoingTest,
            'hasCompleted' => $hasCompleted,
        ]);
    }
}
