<div>
    <!-- Notification Area -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
        @if($notificationStatus === 'success')
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                {{ $notificationMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($notificationStatus === 'error')
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                {{ $notificationMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Manajemen Lowongan') }}</h5>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Lowongan') }}</li>
                    </ul>
                </nav>
            </div>
        </div><!--end container-->
    </section><!--end section-->
    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Main Section -->
    <section class="section">
        <div class="container">
            {{-- PERBAIKAN: Menambahkan blok judul yang terpusat --}}
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="title mb-4">Daftar Lowongan Pekerjaan</h4>
                        <p class="text-muted para-desc mx-auto mb-0">Kelola, filter, dan perbarui status lowongan yang tersedia.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 rounded shadow">
                        <!-- Filter Form -->
                        <div class="m-4">
                            <div class="d-flex justify-content-end mb-3 gap-2">
                                <button wire:click="exportPdf" class="btn btn-sm btn-soft-secondary d-inline-flex align-items-center" title="Export PDF">
                                    <i class="mdi mdi-file-pdf-box me-1"></i> Export PDF
                                </button>
                                <a href="{{ route('Lowongan.Create') }}"
                                   class="btn btn-sm btn-soft-primary d-inline-flex align-items-center"
                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                   title="{{ __('Tambah Lowongan') }}" aria-label="{{ __('Tambah Lowongan') }}">
                                    <i class="mdi mdi-briefcase-plus me-1"></i> {{ __('Tambah Lowongan') }}
                                </a>
                            </div>
                            <div class="row g-1 align-items-center">
                                <div class="col-md-2">
                                    <select wire:model.live="statusFilter" class="form-select form-select-sm py-1">
                                        <option value="">Semua Status</option>
                                        <option value="posted">Diposting</option>
                                        <option value="archived">Diarsipkan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select wire:model.live="kategoriFilter" class="form-select form-select-sm py-1">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoriLowonganOptions as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" wire:model.live="namaPosisiFilter" class="form-control form-control-sm py-1" placeholder="Judul Pekerjaan">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" wire:model.live="tanggalMulaiFilter" class="form-control form-control-sm py-1" placeholder="Tanggal Mulai">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" wire:model.live="tanggalAkhirFilter" class="form-control form-control-sm py-1" placeholder="Tanggal Berakhir">
                                </div>
                                <div class="col-12 col-md-1">
                                    <button type="button"
                                            wire:click="resetFilters"
                                            class="btn btn-soft-secondary btn-sm w-100 d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('Reset Filter') }}" aria-label="{{ __('Reset Filter') }}">
                                        <i class="mdi mdi-filter-remove-outline"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Departemen</th>
                                            <th>Kategori</th>
                                            <th>Tanggal Posting</th>
                                            <th>Tanggal Berakhir</th>
                                            <th class="text-center" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lowongans as $lowongan)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $lowongan->status === 'posted' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($lowongan->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($lowongan->foto)
                                                        <img src="{{ asset('storage/image/lowongan/' . $lowongan->foto) }}" alt="Foto Lowongan" class="img-fluid rounded" style="max-width: 50px;">
                                                    @else
                                                        <span class="text-muted">Tanpa Gambar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" wire:click.prevent="openView({{ $lowongan->id }})" class="fw-bold text-primary">
                                                        {{ $lowongan->nama_posisi }}
                                                    </a>
                                                </td>
                                                <td>{!! Str::limit(strip_tags($lowongan->deskripsi), 50) !!}</td>
                                                <td>{{ $lowongan->departemen }}</td>
                                                <td>{{ optional($lowongan->kategoriLowongan)->nama_kategori }}</td>
                                                <td>{{ date('d M Y', strtotime($lowongan->tanggal_posting)) }}</td>
                                                <td>{{ date('d M Y', strtotime($lowongan->tanggal_berakhir)) }}</td>
                                                <td class="p-3">
                                                    {{-- Tombol Edit --}}
                                                    <a href="{{ route('Lowongan.Edit', $lowongan->id) }}" class="btn btn-sm btn-soft-warning me-1">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>

                                                    {{-- Tombol Kondisional untuk Archive atau Post --}}
                                                    @if($lowongan->status === 'posted')
                                                        <button class="btn btn-sm btn-soft-danger me-1"
                                                            wire:click="confirmStatusChange({{ $lowongan->id }}, 'archive')">
                                                            <i class="mdi mdi-archive-arrow-down-outline"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-soft-success me-1"
                                                            wire:click="confirmStatusChange({{ $lowongan->id }}, 'post')">
                                                            <i class="mdi mdi-publish"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $lowongans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Change Confirmation Modal -->
    @if($showStatusModal)
    <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);"
        role="dialog" aria-labelledby="statusChangeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" wire:click="cancelStatusChange"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $confirmationMessage }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="cancelStatusChange">Batal</button>
                    <button type="button"
                        class="btn {{ $statusAction === 'archive' ? 'btn-danger' : 'btn-success' }}"
                        wire:click="processStatusChange">
                        {{ $statusAction === 'archive' ? 'Ya, Arsipkan' : 'Ya, Posting' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
