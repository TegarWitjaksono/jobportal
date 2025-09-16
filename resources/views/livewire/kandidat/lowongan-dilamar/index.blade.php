<div>
    @php use Illuminate\Support\Facades\Storage; @endphp
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Lacak Lamaran</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lowongan Dilamar</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    <!-- Hero End -->

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow rounded-3">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                                <div>
                                    <h6 class="mb-1">Lowongan yang Kamu Lamar</h6>
                                    <p class="text-muted mb-0">Pantau progres setiap lamaranmu di sini.</p>
                                </div>
                                <div class="w-100 w-md-50" style="max-width: 360px;">
                                    <div class="input-group input-group-sm">
                                        <input type="text"
                                               wire:model.debounce.300ms="search"
                                               class="form-control"
                                               placeholder="Cari posisi atau perusahaan...">
                                        <button class="btn btn-primary btn-sm" type="button">
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications List -->
                            @forelse ($lamaranList as $index => $lamaran)
                                @php
                                    $progress = collect($lamaran->progressRekrutmen ?? []);
                                    $doneStatuses = $progress->pluck('status');
                                    $isAccepted = $doneStatuses->contains('diterima');
                                    $isRejected = $doneStatuses->contains('ditolak');
                                    $hasDecision = $isAccepted || $isRejected;

                                    $latestStatus = optional($progress->last())->status;

                                    $hasScreening = $doneStatuses->contains('screening');
                                    $hasInterview = $doneStatuses->contains('interview');
                                    $hasPsikotes = $doneStatuses->contains('psikotes');

                                    $doneMelamar = in_array($latestStatus, ['screening', 'interview', 'psikotes', 'diterima', 'ditolak']);
                                    $doneInterview = in_array($latestStatus, ['psikotes', 'diterima', 'ditolak']);
                                    $donePsikotes = in_array($latestStatus, ['diterima', 'ditolak']);

                                    $activeStep = null;
                                    if (!$hasDecision) {
                                        if ($latestStatus === 'psikotes') {
                                            $activeStep = 'psikotes';
                                        } elseif (in_array($latestStatus, ['interview', 'screening'], true)) {
                                            $activeStep = 'interview';
                                        } else {
                                            $activeStep = 'melamar';
                                        }
                                    }

                                    $latestInterview = optional($lamaran->progressRekrutmen)
                                        ->where('status', 'interview')
                                        ->sortByDesc('created_at')
                                        ->first();

                                    $lastUpdate = optional($progress->last())->created_at;

                                    $showCbtLink = $hasPsikotes && !$hasDecision;
                                @endphp

                                <div class="card border-0 shadow-sm rounded mb-3">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <!-- Job Info -->
                                            <div class="col-md-4">
                                                <h6 class="fw-semibold mb-1">{{ optional($lamaran->lowongan)->nama_posisi ?? '-' }}</h6>
                                                <p class="text-muted mb-1 small">{{ optional($lamaran->lowongan)->departemen ?? '-' }}</p>
                                                <p class="text-muted mb-1 small">{{ optional($lamaran->lowongan)->lokasi_penugasan ?? '-' }}</p>
                                                <small class="text-muted">Dilamar: {{ optional($lamaran->created_at)->format('d M Y') }}</small>
                                                @if(!empty($lamaran->iklan_lowongan))
                                                    <div class="mt-1"><span class="badge bg-soft-primary text-primary">{{ $lamaran->iklan_lowongan }}</span></div>
                                                @endif
                                            </div>

                                            <!-- Progress Flow -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <!-- Step 1: Melamar -->
                                                    <div class="d-flex align-items-center">
                                                        @if($doneMelamar)
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-check" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-success">Melamar</span>
                                                        @elseif($activeStep === 'melamar')
                                                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-clock-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-warning">Melamar</span>
                                                        @else
                                                            <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-checkbox-blank-circle-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small text-muted">Melamar</span>
                                                        @endif
                                                    </div>

                                                    <!-- Arrow -->
                                                    <i class="mdi mdi-chevron-right text-muted"></i>

                                                    <!-- Step 2: Interview -->
                                                    <div class="d-flex align-items-center">
                                                        @if($doneInterview)
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-check" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-success">Interview</span>
                                                        @elseif($activeStep === 'interview')
                                                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-clock-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-warning">Interview</span>
                                                        @else
                                                            <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-checkbox-blank-circle-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small text-muted">Interview</span>
                                                        @endif
                                                    </div>

                                                    <!-- Arrow -->
                                                    <i class="mdi mdi-chevron-right text-muted"></i>

                                                    <!-- Step 3: Psikotes -->
                                                    <div class="d-flex align-items-center">
                                                        @if($donePsikotes)
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-check" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-success">Psikotes</span>
                                                        @elseif($activeStep === 'psikotes')
                                                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-clock-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small fw-medium text-warning">Psikotes</span>
                                                        @else
                                                            <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                                <i class="mdi mdi-checkbox-blank-circle-outline" style="font-size: 12px;"></i>
                                                            </div>
                                                            <span class="ms-1 small text-muted">Psikotes</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Final Result -->
                                                @if($hasDecision)
                                                    <div class="mt-2">
                                                        @if ($isAccepted)
                                                            <span class="badge bg-soft-success text-success px-2 py-1">
                                                                <i class="mdi mdi-check-circle-outline me-1"></i>Diterima
                                                            </span>
                                                        @elseif ($isRejected)
                                                            <span class="badge bg-soft-danger text-danger px-2 py-1">
                                                                <i class="mdi mdi-close-circle-outline me-1"></i>Ditolak
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Info Interview -->
                                                @if($hasInterview && $latestInterview)
                                                    <div class="mt-2">
                                                        @if($latestInterview->waktu_pelaksanaan)
                                                            <div class="small text-muted">
                                                                Waktu: {{ $latestInterview->waktu_pelaksanaan->format('d M Y H:i') }}
                                                                @if($latestInterview->waktu_selesai)
                                                                    &ndash; {{ $latestInterview->waktu_selesai->format('H:i') }}
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($latestInterview->officer)
                                                            <div class="small text-muted">Interviewer: {{ $latestInterview->officer->name }}</div>
                                                        @endif
                                                        @php $hasInterviewResult = !empty($latestInterview->catatan) || !empty($latestInterview->dokumen_pendukung); @endphp
                                                        @if($latestInterview->link_zoom && !$doneStatuses->contains('psikotes'))
                                                            @php
                                                                $now = \Carbon\Carbon::now();
                                                                $start = $latestInterview->waktu_pelaksanaan;
                                                                $end = $latestInterview->waktu_selesai ?? ($start ? (clone $start)->addMinutes((int)config('zoom.default.duration', 60)) : null);
                                                                $withinWindow = $start && $end ? $now->between($start, $end) : false;
                                                            @endphp
                                                            @if(!$hasInterviewResult && $withinWindow)
                                                                <a href="{{ $latestInterview->link_zoom }}" target="_blank" rel="noopener"
                                                                   class="btn btn-sm btn-soft-primary mt-1 d-inline-flex align-items-center">
                                                                    <i class="mdi mdi-video me-1"></i>Join Zoom
                                                                </a>
                                                            @else
                                                                <span class="badge bg-soft-secondary mt-1"><i class="mdi mdi-video-off-outline me-1"></i> Link Zoom nonaktif</span>
                                                            @endif
                                                        @endif
                                                </div>
                                            @endif
                                            @if($showCbtLink)
                                                <div class="mt-2">
                                                    <a href="{{ route('cbt.dashboard') }}" class="btn btn-sm btn-soft-primary d-inline-flex align-items-center">
                                                        <i class="mdi mdi-pencil me-1"></i>Mulai Psikotes
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Last Update -->
                                        <div class="col-md-2 text-md-end">
                                                @if ($lastUpdate)
                                                    <small class="text-muted">
                                                        Update: {{ $lastUpdate->format('d M Y') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>

                                        @if($isAccepted)
                                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                                <a href="{{ route('kandidat.offer-letter.download', ['lamaranId' => $lamaran->id]) }}" class="btn btn-sm btn-success">
                                                    <i class="mdi mdi-file-pdf-box me-1"></i> Unduh Offering Letter (PDF)
                                                </a>
                                                <a class="btn btn-sm btn-soft-success" data-bs-toggle="collapse" href="#offer-{{ $lamaran->id }}" role="button" aria-expanded="false" aria-controls="offer-{{ $lamaran->id }}">
                                                    <i class="mdi mdi-eye-outline me-1"></i> Pratinjau (Ringkas)
                                                </a>
                                                <div class="collapse mt-2 w-100" id="offer-{{ $lamaran->id }}">
                                                    @include('livewire.kandidat.lowongan-dilamar.offer-letter', ['lamaran' => $lamaran])
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <img src="{{ asset('images/illustrations/empty.svg') }}" alt="" class="mb-3" style="height: 80px;">
                                    <h6 class="mb-1">Belum Ada Lamaran</h6>
                                    <p class="text-muted mb-0">Kamu belum melamar pekerjaan apapun. Mulai jelajahi lowongan yang tersedia!</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-magnify me-1"></i> Cari Lowongan
                                    </a>
                                </div>
                            @endforelse

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $lamaranList->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
