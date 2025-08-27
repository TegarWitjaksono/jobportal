<?php

namespace App\Livewire\Officer\LamaranLowongan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LamarLowongan;
use App\Models\User;
use App\Models\ProgressRekrutmen;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refreshLamaran' => '$refresh'];

    public $officerList = [];

    public $interviewModal = false;
    public $interviewLamaranId;
    public $interviewLink;
    public $interviewWaktu;
    public $interviewOfficer;

    // detail kandidat
    public $detailModal = false;
    public $selectedKandidat;
    public $documents = [];

    // hasil interview
    public $resultModal = false;
    public $resultCatatan;
    public $resultDokumen;


    public function mount()
    {
        $this->officerList = User::where('role', 'officer')->get();
    }

    public function render()
    {
        $lamaran = LamarLowongan::with(['kandidat.user', 'lowongan', 'progressRekrutmen.officer'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->whereHas('lowongan', function ($qq) {
                        $qq->where('nama_posisi', 'like', '%' . $this->search . '%');
                    })->orWhereHas('kandidat.user', function ($qq) {
                        $qq->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.officer.lamaran-lowongan.index', [
            'lamaranList' => $lamaran
        ]);
    }

    // Backward compatible dengan tombol lama
    public function accept($id)
    {
        $this->setStatus($id, 'diterima');
    }

    public function setStatus($id, $status)
    {
        $allowed = ['diterima', 'psikotes', 'ditolak'];
        if (!in_array($status, $allowed, true)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $lamaran = LamarLowongan::findOrFail($id);
    
        try {
            // Tambahkan progress baru
            $lamaran->progressRekrutmen()->create([
                'status' => $status,
                'officer_id' => auth()->id(), // Tambahkan ID officer yang mengubah status
                'nama_progress' => ucfirst($status), // Tambahkan nama progress
                'is_interview' => false,
                'is_psikotes' => $status === 'psikotes',
                'user_create' => auth()->user()->name
            ]);
    
            // Refresh tabel dan beri notifikasi
            $this->dispatch('refreshLamaran');
            session()->flash('success', "Status lamaran diubah ke: {$status}.");
        } catch (\Throwable $e) {
            Log::error('Gagal ubah status lamaran: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan status.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function prepareInterview($lamaranId)
    {
        $this->interviewLamaranId = $lamaranId;
        $this->interviewLink = '';
        $this->interviewWaktu = '';
        $this->interviewOfficer = '';
        $this->interviewModal = true;
    }

    public function saveInterview()
    {
        $this->validate([
            'interviewLink' => 'required|url',
            'interviewWaktu' => 'required|date',
            'interviewOfficer' => 'required|exists:users,id',
        ], [
            'interviewLink.required' => 'Link Zoom wajib diisi.',
            'interviewLink.url' => 'Format Link Zoom tidak valid.',
            'interviewWaktu.required' => 'Waktu pelaksanaan wajib diisi.',
            'interviewOfficer.required' => 'Interviewer wajib dipilih.',
        ]);

        $lamaran = LamarLowongan::findOrFail($this->interviewLamaranId);
        try {
            $lamaran->progressRekrutmen()->create([
                'status' => 'interview',
                'officer_id' => $this->interviewOfficer,
                'nama_progress' => 'Interview',
                'is_interview' => true,
                'waktu_pelaksanaan' => $this->interviewWaktu,
                'link_zoom' => $this->interviewLink,
                'user_create' => auth()->user()->name,
            ]);
            session()->flash('success', 'Interview dijadwalkan.');
            $this->interviewModal = false;
            $this->dispatch('refreshLamaran');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan interview: '.$e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Tampilkan detail kandidat beserta dokumen pendukungnya.
     */
    public function viewDetail($lamaranId)
    {
        $lamaran = LamarLowongan::with('kandidat.user')->findOrFail($lamaranId);
        $this->selectedKandidat = $lamaran->kandidat;

        $fields = [
            'ktp',
            'ijazah',
            'sertifikat',
            'surat_pengalaman',
            'skck',
            'surat_sehat',
        ];

        $files = [];
        foreach ($fields as $field) {
            $column = $field . '_path';
            if ($lamaran->kandidat->$column) {
                $files[$field] = $lamaran->kandidat->$column;
            }
        }

        $this->documents = $files;
        $this->detailModal = true;
    }

    public function closeDetailModal()
    {
        $this->detailModal = false;
        $this->selectedKandidat = null;
        $this->documents = [];
    }

    public function openResult($progressId)
    {
        $progress = ProgressRekrutmen::findOrFail($progressId);
        $this->resultCatatan = $progress->catatan;
        $this->resultDokumen = $progress->dokumen_pendukung;
        $this->resultModal = true;
    }

    public function closeResultModal()
    {
        $this->resultModal = false;
        $this->resultCatatan = null;
        $this->resultDokumen = null;
    }
}
