<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Jadwal Interview</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jadwal Interview</li>
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
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kandidat atau posisi..." wire:model.live="search">
                        <button class="btn btn-primary" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 text-md-end">
                    <button class="btn btn-secondary" wire:click="exportPdf">
                        <i class="mdi mdi-file-pdf-box"></i> Export to PDF
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
                    <div class="table-responsive shadow rounded">
                        <table class="table table-center bg-white mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3 text-center" style="width:5%;">#</th>
                                    <th class="border-bottom p-3" style="width:35%;">Kandidat</th>
                                    <th class="border-bottom p-3" style="width:25%;">Waktu</th>
                                    <th class="border-bottom p-3" style="width:20%;">Link Zoom</th>
                                    <th class="border-bottom p-3" style="width:15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($interviews as $index => $progress)
                                    <tr>
                                        <td class="text-center">{{ $interviews->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar avatar-md rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-account-outline"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ optional($progress->lamarlowongan->kandidat->user)->name ?? '-' }}</div>
                                                    <div class="text-muted small">{{ optional($progress->lamarlowongan->kandidat)->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ optional($progress->waktu_pelaksanaan)->format('d M Y H:i') }}</td>
                                        <td>
                                            @php $hasResult = !empty($progress->catatan) || !empty($progress->dokumen_pendukung); @endphp
                                            @if($progress->link_zoom)
                                                @if(!$hasResult)
                                                    <a href="{{ $progress->link_zoom }}" target="_blank" class="d-block small text-primary">
                                                        <i class="mdi mdi-video me-1"></i> Link Zoom
                                                    </a>
                                                @else
                                                    <span class="d-block small text-muted"><i class="mdi mdi-video-off-outline me-1"></i> Link Zoom nonaktif</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @php $hasResult = !empty($progress->catatan) || !empty($progress->dokumen_pendukung); @endphp
                                            <button class="btn btn-outline-primary btn-sm" wire:click="openResultModal({{ $progress->id }})">
                                                @if($hasResult)
                                                    <i class="mdi mdi-eye-outline"></i> Lihat Hasil Interview
                                                @else
                                                    <i class="mdi mdi-upload"></i> Hasil Interview
                                                @endif
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada jadwal interview.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $interviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Hasil Interview -->
    <div class="modal fade @if($resultModal) show @endif" tabindex="-1" style="@if($resultModal) display:block; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="saveResult" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Hasil Interview</h5>
                        <button type="button" class="btn-close" wire:click="$set('resultModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" wire:model.defer="resultCatatan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dokumen Pendukung</label>
                            <input type="file" class="form-control" wire:model="resultDokumen">
                            @error('resultDokumen') <div class="small text-danger">{{ $message }}</div> @enderror
                            @if($existingResultDokumen)
                                @php $url = Storage::url($existingResultDokumen); $ext = strtolower(pathinfo($existingResultDokumen, PATHINFO_EXTENSION)); @endphp
                                <div class="mt-2">
                                    <div class="small text-muted mb-1">Dokumen saat ini:</div>
                                    @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="Dokumen" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($ext === 'pdf')
                                        <iframe src="{{ $url }}" width="100%" height="240" style="border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @else
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="$set('resultModal', false)">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
