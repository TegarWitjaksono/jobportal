<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Hasil Test CBT</h5>
                    </div>
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
                                    <div class="position-relative">
                                        <i class="mdi mdi-magnify position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
                                        <input type="text" 
                                               wire:model.live.debounce.300ms="search" 
                                               class="form-control ps-5" 
                                               placeholder="Cari berdasarkan nama atau email...">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <label for="sortField" class="form-label me-2 mb-0 text-muted">Urutkan:</label>
                                        <select wire:model.live="sortField" id="sortField" class="form-select w-auto me-2">
                                            <option value="created_at">Tanggal Tes</option>
                                            <option value="user_name">Nama Kandidat</option>
                                            <option value="score">Skor</option>
                                            <option value="started_at">Waktu Mulai</option>
                                        </select>
                                        <select wire:model.live="sortDirection" class="form-select w-auto">
                                            <option value="desc">Menurun</option>
                                            <option value="asc">Menaik</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mdi mdi-account-multiple fs-2"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Total Peserta</h6>
                                                    <h4 class="mb-0">{{ $results->total() }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mdi mdi-check-circle fs-2"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Lulus</h6>
                                                    <h4 class="mb-0">{{  $lulus }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mdi mdi-close-circle fs-2"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Tidak Lulus</h6>
                                                    <h4 class="mb-0">{{ $tidakLulus }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mdi mdi-clock fs-2"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">Rata-rata Skor</h6>
                                                    <h4 class="mb-0">{{ number_format($rataRataSkor, 1) }}%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-center bg-white mb-0">
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
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="mdi mdi-eye me-2"></i>Lihat Detail</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="mdi mdi-download me-2"></i>Export PDF</a></li>
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
</div>