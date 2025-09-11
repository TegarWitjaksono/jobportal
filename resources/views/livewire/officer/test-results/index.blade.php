<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Hasil Psikotes</h5>
                    </div>
                </div>
                <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hasil Psikotes</li>
                    </ul>
                </nav>
            </div>
            </div>
        </div>
    </section>

    <!-- Start -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card border-0 rounded shadow">
                        <div class="card-body">
                            <!-- Filter dan Sorting Controls -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <input type="text"
                                               wire:model.live.debounce.300ms="search"
                                               class="form-control"
                                               placeholder="Cari berdasarkan nama atau email...">
                                        <button class="btn btn-primary btn-sm" type="button">
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3 mt-md-0 text-md-end">
                                    <div class="d-inline-flex flex-wrap align-items-center gap-2">
                                        <span class="text-muted small"><i class="mdi mdi-sort me-1"></i>Urutkan:</span>
                                        <select wire:model.live="sortField" id="sortField" class="form-select form-select-sm w-auto" style="min-width: 180px;">
                                            <option value="created_at">Tanggal Tes</option>
                                            <option value="user_name">Nama Kandidat</option>
                                            <option value="score">Skor</option>
                                            <option value="started_at">Waktu Mulai</option>
                                        </select>
                                        <select wire:model.live="sortDirection" class="form-select form-select-sm w-auto" style="min-width: 180px;">
                                            <option value="desc">Menurun</option>
                                            <option value="asc">Menaik</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Cards -->
                            <div class="row g-3 mb-4">
                                <div class="col-sm-6 col-md-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-account-multiple-outline fs-4"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted small">Total Peserta</div>
                                                    <h4 class="mb-0">{{ $results->total() }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md rounded-circle bg-soft-success text-success d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-check-circle-outline fs-4"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted small">Lulus</div>
                                                    <h4 class="mb-0">{{  $lulus }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md rounded-circle bg-soft-danger text-danger d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-close-circle-outline fs-4"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted small">Tidak Lulus</div>
                                                    <h4 class="mb-0">{{ $tidakLulus }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md rounded-circle bg-soft-info text-info d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-chart-line-variant fs-4"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted small">Rata-rata Skor</div>
                                                    <h4 class="mb-0">{{ number_format($rataRataSkor, 1) }}%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive test-results-wrap">
                                <table class="table table-hover table-center bg-white mb-0 test-results-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-bottom p-3" wire:click="sortBy('user_name')" style="cursor: pointer;">
                                                <div class="d-flex align-items-center">
                                                    Nama Kandidat
                                                    @if($sortField === 'user_name')
                                                        <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                    @endif
                                                </div>
                                            </th>
                                            <th class="border-bottom p-3 text-center" wire:click="sortBy('score')" style="cursor: pointer;">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    Nilai
                                                    @if($sortField === 'score')
                                                        <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                    @endif
                                                </div>
                                            </th>
                                            <th class="border-bottom p-3 text-center">Status</th>
                                            <th class="border-bottom p-3 text-center">Jawaban Benar</th>
                                            <th class="border-bottom p-3 text-center">Total Soal</th>
                                            <th class="border-bottom p-3 text-center" wire:click="sortBy('started_at')" style="cursor: pointer;">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    Waktu Mulai
                                                    @if($sortField === 'started_at')
                                                        <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                    @endif
                                                </div>
                                            </th>
                                            <th class="border-bottom p-3 text-center">Durasi</th>
                                            <th class="border-bottom p-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($results as $result)
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-3">
                                                        <i class="mdi mdi-account text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $result->user->name }}</h6>
                                                        <small class="text-muted">{{ $result->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge bg-{{ $result->score >= 70 ? 'success' : 'danger' }} fs-6 px-3 py-2">
                                                        {{ number_format($result->score, 1) }}%
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                @if($result->score >= 70)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="mdi mdi-check-circle me-1"></i>Lulus
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        <i class="mdi mdi-close-circle me-1"></i>Tidak Lulus
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="fw-semibold text-success">{{ $result->correct_answers }}</span>
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="fw-semibold">{{ $result->total_questions }}</span>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $result->started_at->format('d M Y') }}</span>
                                                    <small class="text-muted">{{ $result->started_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                @if($result->completed_at)
                                                    <span class="badge bg-info-subtle text-info">
                                                        {{ number_format($result->started_at->diffInSeconds($result->completed_at) / 60, 1) }} menit
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="mdi mdi-clock me-1"></i>Belum selesai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="dropdown table-actions">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li><a class="dropdown-item" href="#" wire:click.prevent="openDetail({{ $result->id }})"><i class="mdi mdi-eye me-2"></i>Lihat Detail</a></li>
                                                        <li><a class="dropdown-item" href="#" wire:click.prevent="exportDetail({{ $result->id }})"><i class="mdi mdi-download me-2"></i>Export PDF</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="mdi mdi-delete me-2"></i>Hapus</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center p-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="mdi mdi-file-document-outline fs-1 text-muted mb-3"></i>
                                                    <h6 class="text-muted">{{ $search ? 'Tidak ada hasil yang ditemukan' : 'Belum ada hasil test' }}</h6>
                                                    @if($search)
                                                        <small class="text-muted">Coba ubah kata kunci pencarian</small>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($results->hasPages())
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan {{ $results->firstItem() }} - {{ $results->lastItem() }} dari {{ $results->total() }} hasil
                                </div>
                                <div>
                                    {{ $results->links() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Detail Modal --}}
    @if($detailModal && $detailResult)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.45);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-soft-primary text-primary border-0">
                        <h6 class="modal-title d-flex align-items-center mb-0">
                            <i class="mdi mdi-file-document-outline me-2"></i>
                            Detail Hasil Psikotes
                        </h6>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="closeDetail"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded bg-light">
                                    <div class="text-muted small">Nama</div>
                                    <div class="fw-semibold">{{ optional($detailResult->user)->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded bg-light">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ optional($detailResult->user)->email }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded bg-soft-primary text-primary border">
                                    <div class="text-muted small">Skor</div>
                                    <div class="h5 mb-0">{{ number_format($detailResult->score, 1) }}%</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded bg-soft-success text-success border">
                                    <div class="text-muted small">Benar</div>
                                    <div class="h5 mb-0">{{ $detailResult->correct_answers }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded bg-soft-info text-info border">
                                    <div class="text-muted small">Total Soal</div>
                                    <div class="h5 mb-0">{{ $detailResult->total_questions }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded bg-soft-warning text-warning border">
                                    <div class="text-muted small">Status</div>
                                    <div class="h6 mb-0">{{ $detailResult->completed_at ? 'Selesai' : 'Belum Selesai' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded border">
                                    <div class="text-muted small">Mulai</div>
                                    <div class="fw-semibold">{{ optional($detailResult->started_at)->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded border">
                                    <div class="text-muted small">Selesai</div>
                                    <div class="fw-semibold">{{ optional($detailResult->completed_at)->format('d M Y, H:i') ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded border">
                                    <div class="text-muted small">Durasi</div>
                                    <div class="fw-semibold">
                                        @if($detailResult->completed_at)
                                            {{ number_format($detailResult->started_at->diffInSeconds($detailResult->completed_at) / 60, 1) }} menit
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded border">
                                    <div class="text-muted small">Status Akhir</div>
                                    <div>
                                        @if($detailResult->score >= 70)
                                            <span class="badge bg-soft-success text-success">Lulus</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Tidak Lulus</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-soft-secondary" wire:click="closeDetail">Tutup</button>
                        <button type="button" class="btn btn-soft-primary" wire:click.prevent="exportDetail({{ $detailResult->id }})">
                            <i class="mdi mdi-download me-1"></i> Export PDF
                        </button>
                        <a href="{{ route('test-results.show', $detailResult->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-open-in-new me-1"></i> Buka Review Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
