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
                                        <i class="mdi mdi-magnify position-absolute top-50 translate-middle-y ms-3"></i>
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
                                @endphp
                                <div class="border rounded-3 p-3 p-md-4 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-3">
                                                    <i class="mdi mdi-clipboard-text-outline text-muted"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-semibold mb-1">{{ $l->nama_posisi ?? '-' }}</h6>
                                                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                                                        <span class="d-inline-flex align-items-center"><i class="mdi mdi-office-building me-1"></i> {{ $l->departemen ?? '-' }}</span>
                                                        <span class="d-inline-flex align-items-center"><i class="mdi mdi-map-marker me-1"></i> {{ $l->lokasi_penugasan ?? '-' }}</span>
                                                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1">Tahap: Psikotes</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <div class="d-flex flex-md-column align-items-center justify-content-end gap-2 text-md-end">
                                                <a href="{{ route('cbt.test') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary w-auto">
                                                    <i class="mdi mdi-pencil me-1"></i> Mulai Psikotes
                                                </a>
                                                @if ($lastUpdate)
                                                    <small class="text-muted">Update: {{ $lastUpdate->format('d M Y') }}</small>
                                                @endif
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
                                <span class="badge bg-soft-primary">Total: {{ $total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
