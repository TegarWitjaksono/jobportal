<div>
    <!-- Hero -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Dashboard Psikotes</h5>
                        <p class="text-white-50 mt-2">Daftar pekerjaan Anda yang sudah masuk ke tahap psikotes.</p>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Psikotes</li>
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

    <!-- Content -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow rounded-3">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                                <div>
                                    <h6 class="mb-1">Psikotes Anda</h6>
                                    <p class="text-muted mb-0">Daftar lowongan yang siap dikerjakan tes psikotes.</p>
                                </div>
                                <div class="w-100 w-md-50" style="max-width: 360px;">
                                    <div class="position-relative">
                                        <svg class="fea icon-sm position-absolute top-50 translate-middle-y ms-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                        <input type="text"
                                               wire:model.live.debounce.300ms="search"
                                               class="form-control ps-5"
                                               placeholder="Cari posisi atau departemen...">
                                    </div>
                                </div>
                            </div>

                            @forelse($lamarans as $lamaran)
                                @php
                                    $l = $lamaran->lowongan;
                                    $lastUpdate = optional(optional($lamaran->progressRekrutmen)->last())->created_at;

                                    $psikotesProgress = $lamaran->progressRekrutmen->where('status', 'psikotes')->sortByDesc('created_at')->first();
                                    $waktuMulai = optional($psikotesProgress)->waktu_pelaksanaan ? \Carbon\Carbon::parse($psikotesProgress->waktu_pelaksanaan) : null;
                                    $waktuSelesai = optional($psikotesProgress)->waktu_selesai ? \Carbon\Carbon::parse($psikotesProgress->waktu_selesai) : null;
                                    $now = now();

                                    $isScheduled = $waktuMulai && $waktuSelesai;
                                    $canStartTest = $isScheduled ? $now->between($waktuMulai, $waktuSelesai) : false;
                                @endphp
                                <div class="job-box card rounded shadow border-0 overflow-hidden mb-3">
                                    <div class="p-3 p-md-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <div class="d-flex align-items-center gap-3">
                                                @php
                                                    $thumb = null;
                                                    if (!empty($l?->foto)) {
                                                        $thumb = asset('storage/image/lowongan/' . $l->foto);
                                                    }
                                                @endphp
                                                <div class="avatar avatar-md-sm rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;overflow:hidden;">
                                                    @if($thumb)
                                                        <img src="{{ $thumb }}" alt="{{ $l->nama_posisi ?? 'Lowongan' }}" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
                                                    @else
                                                        <svg class="fea icon-20 text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M16 4h2a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 0 1 2-2h2"></path>
                                                            <path d="M8 2h8v4H8z"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <h6 class="fw-semibold mb-1">{{ $l->nama_posisi ?? '-' }}</h6>
                                                    <div class="text-muted small d-flex flex-column gap-1">
                                                        <span class="d-inline-flex align-items-center"><i class="mdi mdi-office-building me-1"></i> {{ $l->departemen ?? '-' }}</span>
                                                        <span class="d-inline-flex align-items-center">
                                                            <svg class="fea icon-sm me-1 align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"></path>
                                                                <circle cx="12" cy="10" r="3"></circle>
                                                            </svg>
                                                            {{ $l->lokasi_penugasan ?? '-' }}
                                                        </span>
                                                        <span>
                                                            <span class="badge bg-soft-info text-info rounded-pill px-3 py-1">Tahap: Psikotes</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <div class="d-flex flex-md-column align-items-center align-items-md-stretch justify-content-end gap-3 text-md-end">
                                                @if($hasCompleted && $testResult)
                                                    @php
                                                        $scoreValue = (float) $testResult->score;
                                                        $isPassed = $scoreValue >= 70;
                                                        $scoreTone = $isPassed ? 'text-success' : 'text-danger';
                                                        $scoreSurface = $isPassed ? 'bg-soft-success' : 'bg-soft-danger';
                                                    @endphp
                                                    @php
                                                        $progress = max(0, min(100, $scoreValue)); // clamp 0–100
                                                    @endphp

                                                    <div class="w-100">
                                                        <div class="badge {{ $isPassed ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-pill px-3 py-2">
                                                            <i class="mdi {{ $isPassed ? 'mdi-check-all' : 'mdi-close-octagon-outline' }} me-1"></i>
                                                            <strong>{{ number_format($scoreValue, 1) }}%</strong>
                                                            <span class="vr mx-2"></span>
                                                            {{ $isPassed ? 'Lulus' : 'Gagal' }}
                                                        </div>
                                                    </div>
                                                @elseif($ongoingTest && $canStartTest)
                                                    <a href="{{ route('cbt.test') }}" class="btn btn-sm py-2 btn-primary w-100 w-md-auto">
                                                        <i class="mdi mdi-play-circle-outline me-1"></i> Lanjutkan Psikotes
                                                    </a>
                                                @elseif($canStartTest)
                                                    <a href="{{ route('cbt.test') }}" class="btn btn-sm py-2 btn-primary w-100 w-md-auto">
                                                        <i class="mdi mdi-pencil me-1"></i> Mulai Psikotes
                                                    </a>
                                                @else
                                                    <div class="text-center p-3 bg-soft-info rounded w-100 w-md-auto border border-info-subtle shadow-sm">
                                                        @if($isScheduled)
                                                            @if($now->isBefore($waktuMulai))
                                                                <div class="fw-semibold text-info">Tes Belum Dibuka</div>
                                                                <small class="text-muted d-block"><strong>Jadwal: {{ $waktuMulai->format('d M, H:i') }}</strong></small>
                                                            @else
                                                                <div class="fw-semibold text-danger">Waktu Habis</div>
                                                                <small class="text-muted d-block">Berakhir pada {{ $waktuSelesai->format('d M, H:i') }}</small>
                                                            @endif
                                                        @else
                                                            <div class="fw-semibold text-warning">Menunggu Jadwal</div>
                                                            <small class="text-muted d-block">HRD akan segera menjadwalkan tes.</small>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if ($lastUpdate)
                                                    <small class="text-muted">Update: {{ $lastUpdate->format('d M Y') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <img src="{{ asset('images/illustrations/empty.svg') }}" alt="" class="mb-3" style="height: 80px;">
                                    <h6 class="mb-1">Belum Ada Psikotes</h6>
                                    <p class="text-muted mb-0">Anda belum memiliki pekerjaan yang masuk tahap psikotes.</p>
                                </div>
                            @endforelse

                            <div class="d-flex justify-content-end mt-2">
                                <span class="badge bg-soft-primary text-primary">Total: {{ $total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
