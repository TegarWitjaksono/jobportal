<?php

namespace App\Livewire\Officer\LamaranLowongan;

use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LamarLowongan;
use App\Models\User;
use App\Models\ProgressRekrutmen;
use App\Models\TestResult;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\ProctorEvent;
use App\Services\ZoomService;
use Illuminate\Support\Carbon;
use App\Notifications\LamaranDecisionNotification;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $decisionLocked = [];

    protected $listeners = ['refreshLamaran' => '$refresh'];

    public $officerList = [];

    public $interviewModal = false;
    public $interviewLamaranId;
    public $interviewLink;
    public $interviewWaktu;
    public $interviewWaktuSelesai;
    public $interviewOfficer;

    // detail kandidat
    public $detailModal = false;
    public $selectedKandidat;
    public $documents = [];

    // hasil interview
    public $resultModal = false;
    public $resultCatatan;
    public $resultDokumen;

    // psikotes schedule
    public $psikotesModal = false;
    public $psikotesProgressId;
    public $psikotesWaktu;
    public $psikotesWaktuSelesai;

    // offering letter
    public $offeringModal = false;
    public $offeringLamaranId;
    public $offeringType = 'online';
    public $offeringFile;
    public $offeringWaktu;
    public $offeringWaktuSelesai;
    public $offeringLokasi;
    
    // Proctoring
    public $proctorModal = false;
    public $proctorEvents = [];
    public $proctorUserName = null;
    public $proctorSummary = [];


    public function mount()
    {
        $this->officerList = User::where('role', 'officer')->get();
    }

    private function getLamaranQuery()
    {
        return LamarLowongan::with(['kandidat.user', 'lowongan', 'progressRekrutmen.officer'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->whereHas('lowongan', function ($qq) {
                        $qq->where('nama_posisi', 'like', '%' . $this->search . '%');
                    })->orWhereHas('kandidat.user', function ($qq) {
                        $qq->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest();
    }

    private function buildEvidenceUrl(?string $path): ?string
    {
        if (!$path) return null;
        try {
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . ltrim($path, '/'));
            }
        } catch (\Throwable $e) {}
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, '/storage/')) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    public function render()
    {
        $lamaran = $this->getLamaranQuery()->paginate(10);

        // Build map of latest (prefer completed) TestResult per user on this page
        $userIds = $lamaran->getCollection()
            ->map(fn($l) => optional(optional($l->kandidat)->user)->id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $resultMap = [];
        $proctorCountMap = [];
        $proctorThumbMap = [];
        if (!empty($userIds)) {
            $results = TestResult::whereIn('user_id', $userIds)
                ->orderByRaw('CASE WHEN completed_at IS NULL THEN 1 ELSE 0 END ASC')
                ->orderByDesc('completed_at')
                ->orderByDesc('started_at')
                ->get();

            foreach ($results as $res) {
                if (!isset($resultMap[$res->user_id])) {
                    $resultMap[$res->user_id] = $res->id;
                }
            }

            // Count proctor events per user for quick badge
            $counts = ProctorEvent::selectRaw('user_id, COUNT(*) as c')
                ->whereIn('user_id', $userIds)
                ->groupBy('user_id')
                ->pluck('c','user_id');
            foreach ($userIds as $uid) { $proctorCountMap[$uid] = (int) ($counts[$uid] ?? 0); }

            // Latest evidence thumbnail per user (if any)
            $latestIds = ProctorEvent::selectRaw('MAX(id) as id, user_id')
                ->whereIn('user_id', $userIds)
                ->whereNotNull('evidence_path')
                ->groupBy('user_id')
                ->pluck('id','user_id');
            if ($latestIds->isNotEmpty()) {
                $events = ProctorEvent::whereIn('id', $latestIds->values())->get();
                foreach ($events as $e) {
                    if ($e->evidence_path) {
                        $proctorThumbMap[$e->user_id] = $this->buildEvidenceUrl($e->evidence_path);
                    }
                }
            }
        }

        return view('livewire.officer.lamaran-lowongan.index', [
            'lamaranList' => $lamaran,
            'resultMap' => $resultMap,
            'proctorCountMap' => $proctorCountMap,
            'proctorThumbMap' => $proctorThumbMap,
        ]);
    }

    // Backward compatible dengan tombol lama
    public function accept($id)
    {
        $this->setStatus($id, 'diterima');
    }

    public function setStatus($id, $status)
    {
        $allowed = ['screening', 'psikotes', 'ditolak'];
        if (!in_array($status, $allowed, true)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $lamaran = LamarLowongan::findOrFail($id);
        // Cegah klik ganda dan pengubahan keputusan final
        if (in_array($status, ['diterima','ditolak'], true)) {
            if (($this->decisionLocked[$id] ?? false)) {
                return; // sudah terkunci pada sesi ini
            }
            $hasFinal = $lamaran->progressRekrutmen()
                ->whereIn('status', ['diterima','ditolak'])
                ->exists();
            if ($hasFinal) {
                session()->flash('warning', 'Keputusan sudah ditetapkan sebelumnya.');
                $this->decisionLocked[$id] = true;
                return;
            }
        }
    
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
            if (in_array($status, ['diterima','ditolak'], true)) {
                $this->decisionLocked[$id] = true; // kunci setelah keputusan diambil
                // Kirim email ke kandidat
                $user = optional($lamaran->kandidat)->user;
                if ($user && !empty($user->email)) {
                    try {
                        $user->notify(new LamaranDecisionNotification($lamaran, $status, auth()->user()->name));
                    } catch (\Throwable $e) {
                        Log::warning('Gagal mengirim email keputusan/offering: '.$e->getMessage());
                    }
                }
            }
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
        $this->interviewWaktuSelesai = '';
        $this->interviewOfficer = '';
        $this->interviewModal = true;
    }

    public function saveInterview()
    {
        $this->validate([
            'interviewLink' => 'nullable|url',
            'interviewWaktu' => 'required|date',
            'interviewWaktuSelesai' => 'required|date|after:interviewWaktu',
            'interviewOfficer' => 'required|exists:users,id',
        ], [
            'interviewLink.url' => 'Format Link Zoom tidak valid.',
            'interviewWaktu.required' => 'Waktu pelaksanaan wajib diisi.',
            'interviewWaktuSelesai.required' => 'Waktu selesai wajib diisi.',
            'interviewWaktuSelesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'interviewOfficer.required' => 'Interviewer wajib dipilih.',
        ]);

        $lamaran = LamarLowongan::findOrFail($this->interviewLamaranId);
        try {
            // Auto-generate Zoom link if empty
            if (empty($this->interviewLink)) {
                $zoom = app(ZoomService::class);
                if ($zoom->available()) {
                    $topic = 'Interview - ' . optional($lamaran->kandidat->user)->name . ' - ' . optional($lamaran->lowongan)->nama_posisi;
                    $duration = null;
                    try {
                        $start = Carbon::parse($this->interviewWaktu);
                        $end = Carbon::parse($this->interviewWaktuSelesai);
                        $diff = $start && $end ? $start->diffInMinutes($end, false) : null;
                        if (is_int($diff) && $diff > 0) {
                            $duration = max(15, $diff);
                        }
                    } catch (\Throwable $e) {}

                    $meeting = $zoom->createMeeting([
                        'topic' => $topic ?: 'Interview',
                        'start_time' => Carbon::parse($this->interviewWaktu),
                        'duration' => $duration,
                    ]);
                    if ($meeting && !empty($meeting['join_url'])) {
                        $this->interviewLink = $meeting['join_url'];
                    }
                }
            }

            $lamaran->progressRekrutmen()->create([
                'status' => 'interview',
                'officer_id' => $this->interviewOfficer,
                'nama_progress' => 'Interview',
                'is_interview' => true,
                'waktu_pelaksanaan' => $this->interviewWaktu,
                'waktu_selesai' => $this->interviewWaktuSelesai,
                'link_zoom' => $this->interviewLink,
                'user_create' => auth()->user()->name,
            ]);
            if (empty($this->interviewLink)) {
                session()->flash('warning', 'Interview dijadwalkan, namun link Zoom tidak otomatis dibuat. Periksa kredensial/host Zoom dan izin meeting:write:admin.');
            } else {
                session()->flash('success', 'Interview dijadwalkan dan link Zoom dibuat otomatis.');
            }
            $this->interviewModal = false;
            $this->dispatch('refreshLamaran');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan interview: '.$e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function preparePsikotesSchedule($progressId)
    {
        $progress = ProgressRekrutmen::findOrFail($progressId);
        $this->psikotesProgressId = $progress->id;
        $this->psikotesWaktu = $progress->waktu_pelaksanaan ? Carbon::parse($progress->waktu_pelaksanaan)->format('Y-m-d\TH:i') : '';
        $this->psikotesWaktuSelesai = $progress->waktu_selesai ? Carbon::parse($progress->waktu_selesai)->format('Y-m-d\TH:i') : '';
        $this->psikotesModal = true;
    }

    public function savePsikotesSchedule()
    {
        $this->validate([
            'psikotesWaktu' => 'required|date',
            'psikotesWaktuSelesai' => 'required|date|after:psikotesWaktu',
        ], [
            'psikotesWaktu.required' => 'Waktu mulai wajib diisi.',
            'psikotesWaktuSelesai.required' => 'Waktu selesai wajib diisi.',
            'psikotesWaktuSelesai.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        try {
            $progress = ProgressRekrutmen::findOrFail($this->psikotesProgressId);
            $progress->update([
                'waktu_pelaksanaan' => $this->psikotesWaktu,
                'waktu_selesai' => $this->psikotesWaktuSelesai,
            ]);

            session()->flash('success', 'Jadwal psikotes berhasil disimpan.');
            $this->psikotesModal = false;
            $this->dispatch('refreshLamaran');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan jadwal psikotes: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan jadwal.');
        }
    }

    public function prepareOffering($lamaranId)
    {
        $this->offeringLamaranId = $lamaranId;
        $this->reset(['offeringFile', 'offeringWaktu', 'offeringWaktuSelesai', 'offeringLokasi']);
        $this->offeringType = 'online';
        $this->offeringModal = true;
    }

    public function sendOffer()
    {
        $lamaran = LamarLowongan::with('kandidat.user', 'lowongan')->findOrFail($this->offeringLamaranId);
        $user = optional($lamaran->kandidat)->user;

        if ($this->offeringType === 'online') {
            $this->validate([
                'offeringFile' => 'required|file|mimes:pdf|max:2048', // 2MB max
            ], [
                'offeringFile.required' => 'File offering letter wajib diunggah.',
                'offeringFile.mimes' => 'File harus berformat PDF.',
                'offeringFile.max' => 'Ukuran file maksimal 2MB.',
            ]);

            $filePath = $this->offeringFile->store('offering-letters', 'public');

            $lamaran->progressRekrutmen()->create([
                'status' => 'diterima',
                'officer_id' => auth()->id(),
                'nama_progress' => 'Diterima (Online)',
                'dokumen_pendukung' => $filePath,
                'user_create' => auth()->user()->name,
            ]);

            if ($user && !empty($user->email)) {
                $notificationData = ['attachment' => storage_path('app/public/' . $filePath)];
                $user->notify(new LamaranDecisionNotification($lamaran, 'diterima', auth()->user()->name, $notificationData));
            }

        } else { // offline
            $this->validate([
                'offeringWaktu' => 'required|date',
                'offeringWaktuSelesai' => 'required|date|after:offeringWaktu',
                'offeringLokasi' => 'required|string|max:255',
            ], [
                'offeringWaktu.required' => 'Waktu mulai pertemuan wajib diisi.',
                'offeringWaktuSelesai.required' => 'Waktu selesai pertemuan wajib diisi.',
                'offeringWaktuSelesai.after' => 'Waktu selesai harus setelah waktu mulai.',
                'offeringLokasi.required' => 'Lokasi pertemuan wajib diisi.',
            ]);

            $lamaran->progressRekrutmen()->create([
                'status' => 'diterima',
                'officer_id' => auth()->id(),
                'nama_progress' => 'Diterima (Offline)',
                'waktu_pelaksanaan' => $this->offeringWaktu,
                'waktu_selesai' => $this->offeringWaktuSelesai,
                'catatan' => $this->offeringLokasi, // Menggunakan kolom 'catatan' untuk lokasi
                'user_create' => auth()->user()->name,
            ]);

            if ($user && !empty($user->email)) {
                $scheduleDetails = ['waktu' => $this->offeringWaktu, 'waktu_selesai' => $this->offeringWaktuSelesai, 'lokasi' => $this->offeringLokasi];
                $user->notify(new LamaranDecisionNotification($lamaran, 'diterima', auth()->user()->name, ['schedule' => $scheduleDetails]));
            }
        }

        $this->decisionLocked[$lamaran->id] = true;
        $this->offeringModal = false;
        session()->flash('success', "Status lamaran diubah ke 'Diterima' dan notifikasi telah dikirim ke kandidat.");
        $this->dispatch('refreshLamaran');
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

    public function openProctor($userId)
    {
        $user = User::find($userId);
        $this->proctorUserName = optional($user)->name;
        $events = ProctorEvent::where('user_id', $userId)
            ->latest()
            ->limit(100)
            ->get()
            ->map(function($e){
                return [
                    'type' => $e->type,
                    'meta' => $e->meta,
                    'evidence' => $e->evidence_path ? ($this->buildEvidenceUrl($e->evidence_path)) : null,
                    'time' => optional($e->created_at)->format('d M Y H:i:s'),
                ];
            })->toArray();
        $this->proctorEvents = $events;
        // Build summary counts per type
        $summary = [];
        foreach ($events as $row) {
            $t = $row['type'] ?? 'unknown';
            $summary[$t] = ($summary[$t] ?? 0) + 1;
        }
        ksort($summary);
        $this->proctorSummary = $summary;
        $this->proctorModal = true;
    }

    public function closeProctor()
    {
        $this->proctorModal = false;
        $this->proctorEvents = [];
        $this->proctorUserName = null;
        $this->proctorSummary = [];
    }

    /**
     * Export data lamaran ke PDF mengikuti filter saat ini.
     */
    public function exportPdf()
    {
        // Ambil semua data sesuai filter (tanpa paginasi)
        $lamarans = $this->getLamaranQuery()->get();

        // Render view PDF dengan data
        $html = view('livewire.officer.lamaran-lowongan.pdf-export', compact('lamarans'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'daftar-lamaran-lowongan-' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
