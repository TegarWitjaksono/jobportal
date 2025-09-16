<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Kelola Lamaran</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Lamaran</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- Hero End -->

    <section class="section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Cari kandidat atau posisi..." wire:model.live="search">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 text-md-end">
                    <button class="btn btn-soft-secondary btn-sm d-inline-flex align-items-center" wire:click="exportPdf"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Export to PDF" aria-label="Export to PDF">
                        <i class="mdi mdi-file-pdf-box me-1"></i> Export to PDF
                    </button>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="mdi mdi-check-circle-outline me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shadow rounded" wire:poll.20s>
                        <table class="table table-center bg-white mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3 text-center">#</th>
                                    <th class="border-bottom p-3">Kandidat</th>
                                    <th class="border-bottom p-3">Posisi</th>
                                    <th class="border-bottom p-3 text-center">Tanggal Lamar</th>
                                    <th class="border-bottom p-3 text-center">Detail</th>
                                    <th class="border-bottom p-3 text-center">Alur Rekrutmen</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($lamaranList as $index => $lamaran)
                                            @php
                                                $latest = optional($lamaran->progressRekrutmen)->last();
                                                $interviewProgress = $lamaran->progressRekrutmen->firstWhere('status', 'interview');
                                                $screeningProgress = $lamaran->progressRekrutmen->firstWhere('status', 'screening');
                                                $hasScreening = !is_null($screeningProgress);
                                                $isRecruiter = strtolower(optional(auth()->user()->officer)->jabatan) === 'recruiter';
                                                $canPsikotes = !is_null($interviewProgress);

                                                // Status terkini untuk menentukan tahap mana yang aktif
                                                $currentStatus = $latest ? $latest->status : 'pending';
                                                $isCompleted = in_array($currentStatus, ['diterima', 'ditolak']);
                                                $hasInterviewResult = $interviewProgress && (!empty($interviewProgress->catatan) || !empty($interviewProgress->dokumen_pendukung));
                                                $canDecideInterview = $hasInterviewResult && !$isRecruiter && !$isCompleted && $currentStatus === 'interview';
                                                $step1Completed = $hasScreening || in_array($currentStatus, ['screening', 'interview', 'psikotes', 'diterima', 'ditolak']);
                                                $awaitingScreening = !$step1Completed && !$isCompleted;
                                                $screeningOfficer = optional(optional($screeningProgress)->officer)->name ?? optional($screeningProgress)->user_create;
                                                $screeningAt = optional($screeningProgress)->created_at;

                                                // Deteksi progres & penyelesaian psikotes (hijau hanya jika sudah selesai)
                                                $psikotesProgress = optional($lamaran->progressRekrutmen)->where('status', 'psikotes')->sortByDesc('created_at')->first();
                                                $psikotesCompleted = false;
                                                // Pastikan $uid terdefinisi lebih awal untuk digunakan pada beberapa bagian di bawah
                                                $uid = optional(optional($lamaran->kandidat)->user)->id ?? null;
                                                if ($psikotesProgress) {
                                                    $userId = optional(optional($lamaran->kandidat)->user)->id;
                                                    if ($userId) {
                                                        $psikotesCompleted = \App\Models\TestResult::where('user_id', $userId)
                                                            ->whereNotNull('completed_at')
                                                            ->where('completed_at', '>=', $psikotesProgress->created_at)
                                                            ->exists();
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $lamaranList->firstItem() + $index }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar avatar-md rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                            <i class="mdi mdi-account-outline"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ optional($lamaran->kandidat->user)->name ?? '-' }}</div>
                                                            <div class="text-muted small">{{ optional($lamaran->kandidat)->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>{{ optional($lamaran->lowongan)->nama_posisi ?? '-' }}</td>

                                                <td class="text-center">{{ optional($lamaran->created_at)->format('d M Y') }}</td>

                                                <td class="text-center">
                                                    <button class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center"
                                                            wire:click="viewDetail({{ $lamaran->id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Detail kandidat" aria-label="Detail kandidat">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                </td>

                                                <td>
                                                    <div class="recruitment-flow">
                                                        {{-- Step 1: Lamaran Masuk --}}
                                                        <div class="flow-step {{ $step1Completed ? 'completed' : 'active' }}">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon border {{ $step1Completed ? 'bg-soft-success text-success' : 'bg-soft-primary text-primary' }}" data-bs-toggle="tooltip" title="Lamaran Masuk">
                                                                        <i class="mdi mdi-file-document-outline"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Lamaran Masuk</span>
                                                                </div>
                                                                <small class="text-muted">{{ optional($screeningAt ?? $lamaran->created_at)->format('d/m') }}</small>
                                                            </div>

                                                            @if($awaitingScreening)
                                                                <div class="mt-3 bg-light rounded p-3 small">
                                                                    <div class="fw-semibold text-dark mb-2">Detail Kandidat</div>
                                                                    <div class="d-flex flex-column gap-1">
                                                                        <div><span class="text-muted">Nama:</span> {{ optional($lamaran->kandidat->user)->name ?? '-' }}</div>
                                                                        @if(optional($lamaran->kandidat)->no_telpon)
                                                                            <div><span class="text-muted">Telepon:</span> {{ $lamaran->kandidat->no_telpon }}</div>
                                                                        @endif
                                                                        <div><span class="text-muted">Email:</span> {{ optional(optional($lamaran->kandidat)->user)->email ?? '-' }}</div>
                                                                        @if(optional($lamaran->kandidat)->alamat)
                                                                            <div><span class="text-muted">Alamat:</span> {{ $lamaran->kandidat->alamat }}</div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                                                        <button type="button" class="btn btn-soft-secondary btn-sm" wire:click="viewDetail({{ $lamaran->id }})">
                                                                            <i class="mdi mdi-account-box me-1"></i> Lihat Profil
                                                                        </button>
                                                                        <button type="button" class="btn btn-success btn-sm" wire:click.prevent="setStatus({{ $lamaran->id }}, 'screening')" wire:loading.attr="disabled" wire:target="setStatus">
                                                                            <i class="mdi mdi-check me-1"></i> Terima
                                                                        </button>
                                                                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click.prevent="setStatus({{ $lamaran->id }}, 'ditolak')" wire:loading.attr="disabled" wire:target="setStatus">
                                                                            <i class="mdi mdi-close me-1"></i> Tolak
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @elseif($screeningProgress)
                                                                <div class="mt-3 bg-light rounded p-3 small">
                                                                    <div class="text-muted">Disetujui oleh <span class="text-dark">{{ $screeningOfficer ?? 'Sistem' }}</span></div>
                                                                    @if($screeningAt)
                                                                        <div class="text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $screeningAt->format('d M Y, H:i') }}</div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector {{ $step1Completed ? '' : 'disabled' }}"></div>

                                                        {{-- Step 2: Interview --}}
                                                        <div class="flow-step {{ $interviewProgress ? 'completed' : ($step1Completed ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon border {{ $interviewProgress ? 'bg-soft-success text-success' : ($step1Completed ? 'bg-soft-primary text-primary' : 'bg-soft-secondary text-muted') }}" data-bs-toggle="tooltip" title="Interview">
                                                                        <i class="mdi mdi-calendar-clock"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Interview</span>
                                                                </div>
                                                                @if(!$interviewProgress && $step1Completed && !$isRecruiter && !$isCompleted)
                                                                    <button type="button" class="btn btn-sm btn-soft-primary" 
                                                                            wire:click.prevent="prepareInterview({{ $lamaran->id }})"
                                                                            data-bs-toggle="tooltip" title="Jadwalkan Interview">
                                                                        <i class="mdi mdi-plus"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($interviewProgress)
                                                                <div class="interview-details bg-light rounded p-2 small">
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <div>
                                                                            <div class="text-muted">Interviewer:</div>
                                                                            <div class="fw-medium">{{ optional($interviewProgress->officer)->name }}</div>
                                                                        </div>
                                                                        @if($interviewProgress->catatan || $interviewProgress->dokumen_pendukung)
                                                                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="openResult({{ $interviewProgress->id }})" data-bs-toggle="tooltip" title="Lihat Hasil Interview">
                                                                                <i class="mdi mdi-file-document me-1"></i> Lihat Hasil
                                                                            </button>
                                                                        @else
                                                                            <a href="{{ $interviewProgress->link_zoom }}" target="_blank"
                                                                               class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Buka Zoom">
                                                                                <i class="mdi mdi-video me-1"></i> Zoom
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                    @if($interviewProgress->waktu_pelaksanaan)
                                                                        <div class="text-muted mt-1">
                                                                            <i class="mdi mdi-clock-outline me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($interviewProgress->waktu_pelaksanaan)->format('d M Y, H:i') }}
                                                                            @if($interviewProgress->waktu_selesai)
                                                                                &ndash; {{ \Carbon\Carbon::parse($interviewProgress->waktu_selesai)->format('H:i') }}
                                                                            @endif
                                                                        </div>
                                                                    @endif

                                                                    @php $pcount = ($uid && isset($proctorCountMap[$uid])) ? (int) $proctorCountMap[$uid] : 0; @endphp
                                                                    <button type="button" class="btn btn-sm {{ $pcount ? 'btn-soft-danger' : 'btn-soft-secondary' }}"
                                                                            wire:click="openProctor({{ (int) $uid }})"
                                                                            @disabled(!$uid)
                                                                            data-bs-toggle="tooltip" title="Laporan Proctoring">
                                                                        <i class="mdi mdi-alert-outline"></i>
                                                                        @if($pcount)
                                                                            <span class="badge bg-danger ms-1">{{ $pcount }}</span>
                                                                        @endif
                                                                    </button>

                                                                    @if($canDecideInterview)
                                                                        <div class="interview-decision-card mt-3 small">
                                                                            <div class="d-flex align-items-start gap-2">
                                                                                <div class="decision-icon">
                                                                                    <i class="mdi mdi-progress-check"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="fw-semibold text-dark">Keputusan Interview</div>
                                                                                    <div class="text-muted">Hasil interview telah diterima. Tentukan kelanjutan kandidat.</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex flex-wrap gap-2 mt-3">
                                                                                <button type="button" class="btn btn-success btn-sm d-inline-flex align-items-center"
                                                                                        wire:click.prevent="setStatus({{ $lamaran->id }}, 'psikotes')"
                                                                                        wire:loading.attr="disabled" wire:target="setStatus">
                                                                                    <i class="mdi mdi-check-circle-outline me-1"></i> Lanjut ke Psikotes
                                                                                </button>
                                                                                <button type="button" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center"
                                                                                        wire:click.prevent="setStatus({{ $lamaran->id }}, 'ditolak')"
                                                                                        wire:loading.attr="disabled" wire:target="setStatus">
                                                                                    <i class="mdi mdi-close-circle-outline me-1"></i> Tidak Lanjut
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($hasInterviewResult && $currentStatus === 'interview')
                                                                        <div class="mt-3 text-muted small">
                                                                            <i class="mdi mdi-information-outline me-1"></i>Hasil interview telah dikirim. Menunggu keputusan HR.
                                                                        </div>
                                                                    @endif


                                                                </div>
                                                            @elseif($step1Completed && $isRecruiter && !$isCompleted)
                                                                <div class="text-muted small">
                                                                    <i class="mdi mdi-information-outline me-1"></i>
                                                                    Hanya HRD yang dapat menjadwalkan interview
                                                                </div>
                                                            @elseif($step1Completed && !$isCompleted)
                                                                <div class="text-muted small">Menunggu penjadwalan interview.</div>
                                                            @elseif($isCompleted)
                                                                <div class="text-muted small">Proses rekrutmen telah selesai.</div>
                                                            @else
                                                                <div class="text-muted small">Menunggu keputusan tahap 1.</div>
                                                            @endif
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector {{ $canPsikotes ? '' : 'disabled' }}"></div>

                                                        {{-- Step 3: Psikotes --}}
                                                        <div class="flow-step {{ $psikotesCompleted ? 'completed' : ($canPsikotes && in_array($currentStatus, ['interview','psikotes']) ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon border {{ $psikotesCompleted ? 'bg-soft-success text-success' : ($canPsikotes && in_array($currentStatus, ['interview','psikotes']) ? 'bg-soft-warning text-warning' : 'bg-soft-secondary text-muted') }}" data-bs-toggle="tooltip" title="Psikotes">
                                                                        <i class="mdi mdi-brain"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Psikotes</span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @php
                                                                        $resId = $uid ? ($resultMap[$uid] ?? null) : null;
                                                                    @endphp
                                                                    @if($resId)
                                                                        <a href="{{ route('test-results.show', $resId) }}" target="_blank" rel="noopener"
                                                                           class="btn btn-sm btn-soft-info"
                                                                           data-bs-toggle="tooltip" title="Review Psikotes">
                                                                            <i class="mdi mdi-file-eye-outline"></i>
                                                                        </a>
                                                                    @endif

                                                                    @if($canPsikotes && $currentStatus == 'interview')
                                                                        @if(!$hasInterviewResult)
                                                                            <div class="text-muted small flex-grow-1">Menunggu hasil interview dari recruiter.</div>
                                                                        @elseif($isRecruiter)
                                                                            <div class="text-muted small flex-grow-1">Hasil interview telah dikirim. Menunggu keputusan HR.</div>
                                                                        @else
                                                                            <div class="text-muted small flex-grow-1">Silakan tentukan kelanjutan pada tahap interview.</div>
                                                                        @endif
                                                                    @elseif(!$canPsikotes)
                                                                        <small class="text-muted">Setelah interview</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector {{ ($psikotesCompleted || $isCompleted) ? '' : 'disabled' }}"></div>

                                                        {{-- Step 4: Keputusan Final --}}
                                                        <div class="flow-step {{ $isCompleted ? 'completed' : ($psikotesCompleted ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon border {{ $currentStatus == 'diterima' ? 'bg-soft-success text-success' : ($currentStatus == 'ditolak' ? 'bg-soft-danger text-danger' : ($psikotesCompleted ? 'bg-soft-info text-info' : 'bg-soft-secondary text-muted')) }}" data-bs-toggle="tooltip" title="Keputusan">
                                                                        <i class="mdi {{ $currentStatus == 'diterima' ? 'mdi-check-circle' : ($currentStatus == 'ditolak' ? 'mdi-close-circle' : 'mdi-gavel') }}"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Keputusan</span>
                                                                </div>
                                                                
                                                                @php
                                                                    $finalProgress = optional($lamaran->progressRekrutmen)
                                                                        ->whereIn('status', ['diterima','ditolak'])
                                                                        ->sortByDesc('created_at')
                                                                        ->first();
                                                                    $hasFinal = !is_null($finalProgress);
                                                                    $deciderName = optional(optional($finalProgress)->officer)->name
                                                                        ?? ($finalProgress->user_create ?? null);
                                                                    $decidedAt = optional($finalProgress)->created_at;
                                                                @endphp

                                                                @if($psikotesCompleted && !$isRecruiter && !$hasFinal)
                                                                    <div class="d-flex gap-1">
                                                                        <button type="button" class="btn btn-sm btn-soft-success"
                                                                                wire:click.prevent="setStatus({{ $lamaran->id }}, 'diterima')"
                                                                                wire:loading.attr="disabled" wire:target="setStatus"
                                                                                data-bs-toggle="tooltip" title="Terima Kandidat"
                                                                                @disabled(($decisionLocked[$lamaran->id] ?? false))>
                                                                            <span wire:loading.remove wire:target="setStatus">
                                                                                <i class="mdi mdi-check"></i>
                                                                            </span>
                                                                            <span wire:loading wire:target="setStatus">
                                                                                <i class="mdi mdi-loading mdi-spin"></i>
                                                                            </span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-soft-danger"
                                                                                wire:click.prevent="setStatus({{ $lamaran->id }}, 'ditolak')"
                                                                                wire:loading.attr="disabled" wire:target="setStatus"
                                                                                data-bs-toggle="tooltip" title="Tolak Kandidat"
                                                                                @disabled(($decisionLocked[$lamaran->id] ?? false))>
                                                                                <span wire:loading.remove wire:target="setStatus">
                                                                                    <i class="mdi mdi-close"></i>
                                                                                </span>
                                                                                <span wire:loading wire:target="setStatus">
                                                                                    <i class="mdi mdi-loading mdi-spin"></i>
                                                                                </span>
                                                                        </button>
                                                                    </div>
                                                                @elseif($isCompleted || $hasFinal)
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <span class="badge bg-{{ $currentStatus == 'diterima' ? 'success' : 'danger' }}">
                                                                            {{ ucfirst($currentStatus) }}
                                                                        </span>
                                                                    </div>
                                                                @elseif(!$psikotesCompleted)
                                                                    <small class="text-muted">Setelah psikotes</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($isCompleted || $hasFinal)
                                                            @php
                                                                // Pastikan variabel tersedia di luar header
                                                                $finalProgress = $finalProgress ?? (optional($lamaran->progressRekrutmen)
                                                                    ->whereIn('status', ['diterima','ditolak'])
                                                                    ->sortByDesc('created_at')
                                                                    ->first());
                                                                $deciderName = $deciderName ?? (optional(optional($finalProgress)->officer)->name
                                                                    ?? ($finalProgress->user_create ?? null));
                                                                $decidedAt = $decidedAt ?? optional($finalProgress)->created_at;
                                                            @endphp
                                                            <div class="decision-details bg-light rounded p-2 small mt-2">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <div class="text-muted">Pengambil Keputusan:</div>
                                                                        <div class="fw-medium">{{ $deciderName ?: '-' }}</div>
                                                                    </div>
                                                                    @if($decidedAt)
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-clock-outline me-1"></i>
                                                                            {{ $decidedAt->format('d M Y, H:i') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="text-center py-5">
                                                        <img src="{{ asset('images/illustrations/empty.svg') }}" alt="" class="mb-3" style="height: 80px;">
                                                        <h6 class="mb-1">Belum Ada Lamaran</h6>
                                                        <p class="text-muted mb-0">Lamaran akan tampil di sini setelah kandidat melamar lowongan.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $lamaranList->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
    </section>

    <!-- Modal Jadwalkan Interview -->
    <div class="modal fade @if($interviewModal) show @endif" tabindex="-1" style="@if($interviewModal) display:block; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="saveInterview">
                    <div class="modal-header">
                        <h5 class="modal-title">Jadwalkan Interview</h5>
                        <button type="button" class="btn-close" wire:click="$set('interviewModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Link Zoom</label>
                            <input type="url" class="form-control" wire:model.defer="interviewLink" placeholder="Kosongkan untuk generate otomatis">
                            <small class="text-muted">Biarkan kosong untuk membuat link Zoom otomatis dari akun host default.</small>
                            @error('interviewLink') <div class="small text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu Pelaksanaan</label>
                            <input type="datetime-local" class="form-control" wire:model.defer="interviewWaktu" required>
                            @error('interviewWaktu') <div class="small text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control" wire:model.defer="interviewWaktuSelesai" required>
                            @error('interviewWaktuSelesai') <div class="small text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Interviewer</label>
                            <select class="form-select" wire:model.defer="interviewOfficer" required>
                                <option value="">Pilih Officer</option>
                                @foreach($officerList as $officer)
                                    <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                @endforeach
                            </select>
                            @error('interviewOfficer') <div class="small text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="$set('interviewModal', false)">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kandidat -->
    <div class="modal fade @if($detailModal) show @endif" tabindex="-1" style="@if($detailModal) display:block; background-color: rgba(0,0,0,0.5); @endif">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Detail Kandidat</h5>
                    <button type="button" class="btn-close" wire:click="closeDetailModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedKandidat)
                        {{-- Header kandidat dengan avatar (konsisten dengan halaman Kandidat) --}}
                        @php $photo = optional(optional($selectedKandidat)->user)->profile_photo_url ?? null; @endphp
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;overflow:hidden;">
                                @if($photo)
                                    <img src="{{ $photo }}" alt="Avatar" style="width:48px;height:48px;object-fit:cover;">
                                @else
                                    <i class="mdi mdi-account-outline fs-4 text-muted"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold">{{ optional($selectedKandidat)->nama_depan }} {{ optional($selectedKandidat)->nama_belakang }}</div>
                                <div class="text-muted small">{{ optional(optional($selectedKandidat)->user)->email }}</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            {{-- Data Tes (BMI) --}}
                            @if(optional($selectedKandidat)->bmi_score)
                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-2">
                                    <i class="mdi mdi-file-document me-2"></i>Data Tes
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Skor BMI</div>
                                    <div class="fw-semibold fs-5">{{ $selectedKandidat->bmi_score }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Kategori BMI</div>
                                    <div>
                                        @php $cat = $selectedKandidat->bmi_category; @endphp
                                        @switch($cat)
                                            @case('Kurus')
                                                <span class="badge bg-soft-warning">{{ $cat }}</span>
                                                @break
                                            @case('Normal')
                                                <span class="badge bg-soft-success">{{ $cat }}</span>
                                                @break
                                            @case('Gemuk')
                                                <span class="badge bg-soft-danger">{{ $cat }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-soft-secondary">{{ $cat ?? '-' }}</span>
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">No. Telepon</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->no_telpon }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">No. KTP</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->no_ktp }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Alamat</div>
                                    <div class="fw-semibold">{{ method_exists($selectedKandidat, 'getFormattedAddressAttribute') ? $selectedKandidat->getFormattedAddressAttribute() : '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Tempat, Tanggal Lahir</div>
                                    <div class="fw-semibold">
                                        {{ optional($selectedKandidat)->tempat_lahir }},
                                        {{ optional($selectedKandidat->tanggal_lahir)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Jenis Kelamin</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->jenis_kelamin }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Status Perkawinan</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->status_perkawinan }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Agama</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->agama }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Pendidikan Tertinggi</div>
                                    <div class="fw-semibold">{{ optional($selectedKandidat)->pendidikan ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2 rounded border bg-light">
                                    <div class="text-muted small mb-1">Keahlian Lainnya</div>
                                    <div class="fw-semibold" style="white-space: pre-wrap;">{{ optional($selectedKandidat)->kemampuan ?: '-' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Riwayat Pengalaman Kerja --}}
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2">
                                <i class="mdi mdi-briefcase-outline me-2"></i>Riwayat Pengalaman Kerja
                            </h6>
                            @php
                                $workData = optional($selectedKandidat)->riwayat_pengalaman_kerja ?? [];
                                if (!is_array($workData)) { $workData = json_decode($workData, true) ?: []; }
                            @endphp
                            @if($workData)
                                @foreach($workData as $item)
                                    <div class="p-2 rounded border bg-light mb-2">
                                        <div class="fw-semibold mb-0">{{ $item['position'] ?? '-' }} - {{ $item['company'] ?? '-' }}</div>
                                        <small class="text-muted d-block">{{ $item['start'] ?? '-' }} - {{ $item['end'] ?? '-' }}</small>
                                        <div class="small mb-0">Bisnis: {{ $item['business'] ?? '-' }}</div>
                                        <div class="small mb-0">Alasan keluar: {{ $item['reason'] ?? '-' }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted">Belum ada riwayat pengalaman kerja.</div>
                            @endif
                        </div>

                        {{-- Riwayat Pendidikan --}}
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2">
                                <i class="mdi mdi-school-outline me-2"></i>Riwayat Pendidikan
                            </h6>
                            @php
                                $eduData = optional($selectedKandidat)->riwayat_pendidikan ?? [];
                                if (!is_array($eduData)) { $eduData = json_decode($eduData, true) ?: []; }
                            @endphp
                            @if($eduData)
                                @foreach($eduData as $item)
                                    <div class="p-2 rounded border bg-light mb-2">
                                        <div class="fw-semibold mb-0">{{ $item['name'] ?? '-' }} - {{ $item['major'] ?? '-' }}</div>
                                        <small class="text-muted d-block">{{ $item['start'] ?? '-' }} - {{ $item['end'] ?? '-' }}</small>
                                        <div class="small mb-0">Tingkat: {{ $item['level'] ?? '-' }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted">Belum ada riwayat pendidikan.</div>
                            @endif
                        </div>

                        {{-- Keterampilan Bahasa --}}
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2">
                                <i class="mdi mdi-translate me-2"></i>Keterampilan Bahasa
                            </h6>
                            @php
                                $langData = optional($selectedKandidat)->kemampuan_bahasa ?? [];
                                if (!is_array($langData)) { $langData = json_decode($langData, true) ?: []; }
                            @endphp
                            @if($langData)
                                @foreach($langData as $item)
                                    <div class="p-2 rounded border bg-light mb-2">
                                        <div class="fw-semibold mb-0">{{ $item['language'] ?? '-' }}</div>
                                        <div class="small mb-0">Berbicara: {{ $item['speaking'] ?? '-' }}, Membaca: {{ $item['reading'] ?? '-' }}, Menulis: {{ $item['writing'] ?? '-' }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted">Belum ada keterampilan bahasa.</div>
                            @endif
                        </div>

                        {{-- Informasi Spesifik --}}
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2">
                                <i class="mdi mdi-information-outline me-2"></i>Informasi Spesifik
                            </h6>
                            @php
                                $spec = optional($selectedKandidat)->informasi_spesifik ?? [];
                                if (!is_array($spec)) { $spec = json_decode($spec, true) ?: []; }
                            @endphp
                            @if($spec)
                                <div class="p-2 rounded border bg-light">
                                    <div class="mb-1">Pernah bekerja di perusahaan ini? <strong>{{ $spec['pernah'] ?? '-' }}</strong></div>
                                    @if(isset($spec['pernah']) && $spec['pernah'] === 'Ya')
                                        <div class="mb-1">Lokasi: <strong>{{ $spec['lokasi'] ?? '-' }}</strong></div>
                                    @endif
                                    <div class="mb-0">Sumber informasi pekerjaan: <strong>{{ $spec['info'] ?? '-' }}</strong></div>
                                </div>
                            @else
                                <div class="text-muted">Belum ada informasi spesifik.</div>
                            @endif
                        </div>

                        {{-- Dokumen Pendukung --}}
                        <div class="mt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2">
                                <i class="mdi mdi-file-upload-outline me-2"></i>Dokumen Pendukung
                            </h6>
                            @php
                                $docMap = [
                                    'KTP' => optional($selectedKandidat)->ktp_path ?? ($documents['ktp'] ?? null),
                                    'Ijazah' => optional($selectedKandidat)->ijazah_path ?? ($documents['ijazah'] ?? null),
                                    'Sertifikat' => optional($selectedKandidat)->sertifikat_path ?? ($documents['sertifikat'] ?? null),
                                    'Surat Pengalaman Kerja' => optional($selectedKandidat)->surat_pengalaman_path ?? ($documents['surat_pengalaman'] ?? null),
                                    'SKCK' => optional($selectedKandidat)->skck_path ?? ($documents['skck'] ?? null),
                                    'Surat Sehat' => optional($selectedKandidat)->surat_sehat_path ?? ($documents['surat_sehat'] ?? null),
                                ];
                            @endphp
                            <div class="row g-2">
                                @foreach($docMap as $label => $path)
                                    <div class="col-md-6">
                                        <div class="p-2 rounded border bg-light d-flex justify-content-between align-items-center">
                                            <div class="text-muted small mb-0">{{ $label }}</div>
                                            @if(!empty($path))
                                                <a href="{{ Storage::url($path) }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i> Lihat</a>
                                            @else
                                                <span class="text-muted small">Belum diunggah</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @if($detailModal)
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Modal Hasil Interview -->
    <div class="modal fade @if($resultModal) show @endif" tabindex="-1" style="@if($resultModal) display:block; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Interview</h5>
                    <button type="button" class="btn-close" wire:click="closeResultModal"></button>
                </div>
                <div class="modal-body">
                    @if($resultCatatan)
                        <p class="mb-3">{{ $resultCatatan }}</p>
                    @endif

                    @if($resultDokumen)
                        @php
                            $url = \Illuminate\Support\Facades\Storage::url($resultDokumen);
                            $ext = strtolower(pathinfo($resultDokumen, PATHINFO_EXTENSION));
                        @endphp
                        <div class="mb-2 fw-semibold">Dokumen Pendukung:</div>
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <img src="{{ $url }}" alt="Dokumen Pendukung" class="img-fluid rounded border" style="max-height: 400px;">
                        @elseif($ext === 'pdf')
                            <iframe src="{{ $url }}" width="100%" height="500px" style="border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                        @else
                            <a href="{{ $url }}" target="_blank" class="btn btn-soft-primary">
                                <i class="mdi mdi-file-download-outline me-1"></i> Lihat / Unduh Dokumen
                            </a>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" wire:click="closeResultModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .recruitment-flow {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        min-width: 280px;
    }

    .flow-step {
        position: relative;
        margin-bottom: 12px;
    }

    .flow-step:last-child {
        margin-bottom: 0;
    }

    .step-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .flow-connector {
        width: 2px;
        height: 15px;
        background: #28a745;
        margin: 2px 0 2px 15px;
    }

    .flow-connector.disabled {
        background: #dee2e6;
    }

    /* Step icon coloring handled via Bootstrap soft color classes in markup */

    .interview-details {
        margin-left: 44px;
        margin-top: 8px;
    }

    .interview-decision-card {
        background-color: #ffffff;
        border: 1px solid rgba(13, 110, 253, 0.15);
        border-radius: 8px;
        padding: 14px 16px;
    }

    .interview-decision-card .decision-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.12);
        color: #0d6efd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .flow-step .btn-sm {
        font-size: 11px;
        padding: 4px 8px;
    }

    @media (max-width: 768px) {
        .recruitment-flow {
            min-width: 250px;
        }
        
        .interview-details {
            margin-left: 0;
        }
    }
    </style>
</div>

    {{-- Proctor Modal --}}
    @if($proctorModal)
    <div class="modal fade show" style="display:block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-soft-danger text-danger border-0">
                    <h5 class="modal-title d-flex align-items-center mb-0"><i class="mdi mdi-alert-outline me-2"></i>Laporan Proctoring {{ $proctorUserName ? ' - '.$proctorUserName : '' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeProctor"></button>
                </div>
                <div class="modal-body">
                    @if(empty($proctorEvents))
                        <div class="text-muted">Belum ada pelanggaran tercatat.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 140px;">Waktu</th>
                                        <th>Jenis</th>
                                        <th>Detail</th>
                                        <th style="width: 160px;">Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($proctorEvents as $e)
                                    <tr>
                                        <td class="text-muted small">{{ $e['time'] ?? '-' }}</td>
                                        <td><span class="badge bg-soft-danger text-danger text-uppercase">{{ $e['type'] }}</span></td>
                                        <td class="small">
                                            @php $m = $e['meta'] ?? []; @endphp
                                            @if(is_array($m) && !empty($m))
                                                @if(!empty($m['count']))<div>Faces: {{ $m['count'] }}</div>@endif
                                                @if(!empty($m['last_url']))<div>Last URL: <a href="{{ $m['last_url'] }}" target="_blank" rel="noopener">{{ $m['last_url'] }}</a></div>@endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($e['evidence']))
                                                <img src="{{ $e['evidence'] }}" alt="Evidence" class="img-fluid rounded border" style="max-height:120px;">
                                            @else
                                                <span class="text-muted small">Tidak ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-soft-secondary" wire:click="closeProctor">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif
