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
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
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
                                                $isRecruiter = strtolower(optional(auth()->user()->officer)->jabatan) === 'recruiter';
                                                $canPsikotes = !is_null($interviewProgress);
                                                
                                                // Status terkini untuk menentukan tahap mana yang aktif
                                                $currentStatus = $latest ? $latest->status : 'pending';
                                                $isCompleted = in_array($currentStatus, ['diterima', 'ditolak']);
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
                                                    <button class="btn btn-outline-primary btn-sm" title="Detail kandidat" wire:click="viewDetail({{ $lamaran->id }})">
                                                        <i class="mdi mdi-account-details"></i>
                                                    </button>
                                                </td>

                                                <td>
                                                    <div class="recruitment-flow">
                                                        {{-- Step 1: Lamaran Masuk --}}
                                                        <div class="flow-step completed">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon bg-success text-white">
                                                                        <i class="mdi mdi-file-document-outline"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Lamaran Masuk</span>
                                                                </div>
                                                                <small class="text-muted">{{ $lamaran->created_at->format('d/m') }}</small>
                                                            </div>
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector"></div>

                                                        {{-- Step 2: Interview --}}
                                                        <div class="flow-step {{ $interviewProgress ? 'completed' : ($currentStatus == 'pending' ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon {{ $interviewProgress ? 'bg-success text-white' : ($currentStatus == 'pending' ? 'bg-primary text-white' : 'bg-light text-muted') }}">
                                                                        <i class="mdi mdi-calendar-clock"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Interview</span>
                                                                </div>
                                                                @if(!$interviewProgress && $currentStatus == 'pending' && !$isRecruiter)
                                                                    <button type="button" class="btn btn-primary btn-sm" 
                                                                            wire:click.prevent="prepareInterview({{ $lamaran->id }})"
                                                                            title="Jadwalkan Interview">
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
                                                                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="openResult({{ $interviewProgress->id }})">
                                                                                <i class="mdi mdi-file-document me-1"></i> Lihat Hasil
                                                                            </button>
                                                                        @else
                                                                            <a href="{{ $interviewProgress->link_zoom }}" target="_blank"
                                                                               class="btn btn-outline-primary btn-sm">
                                                                                <i class="mdi mdi-video me-1"></i> Zoom
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                    @if($interviewProgress->waktu_pelaksanaan)
                                                                        <div class="text-muted mt-1">
                                                                            <i class="mdi mdi-clock-outline me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($interviewProgress->waktu_pelaksanaan)->format('d M Y, H:i') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @elseif($isRecruiter && $currentStatus == 'pending')
                                                                <div class="text-muted small">
                                                                    <i class="mdi mdi-information-outline me-1"></i>
                                                                    Hanya HRD yang dapat menjadwalkan interview
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector {{ $canPsikotes ? '' : 'disabled' }}"></div>

                                                        {{-- Step 3: Psikotes --}}
                                                        <div class="flow-step {{ $currentStatus == 'psikotes' ? 'completed' : ($canPsikotes && $currentStatus == 'interview' ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon {{ $currentStatus == 'psikotes' ? 'bg-success text-white' : ($canPsikotes && $currentStatus == 'interview' ? 'bg-warning text-white' : 'bg-light text-muted') }}">
                                                                        <i class="mdi mdi-brain"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Psikotes</span>
                                                                </div>
                                                                @if($canPsikotes && $currentStatus == 'interview' && !$isRecruiter && !$isCompleted)
                                                                    <button type="button" class="btn btn-warning btn-sm" 
                                                                            wire:click.prevent="setStatus({{ $lamaran->id }}, 'psikotes')"
                                                                            title="Lanjut ke Psikotes">
                                                                        <i class="mdi mdi-arrow-right"></i>
                                                                    </button>
                                                                @elseif(!$canPsikotes)
                                                                    <small class="text-muted">Setelah interview</small>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- Connection Line --}}
                                                        <div class="flow-connector {{ ($currentStatus == 'psikotes' || $isCompleted) ? '' : 'disabled' }}"></div>

                                                        {{-- Step 4: Keputusan Final --}}
                                                        <div class="flow-step {{ $isCompleted ? 'completed' : ($currentStatus == 'psikotes' ? 'active' : 'disabled') }}">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="step-icon {{ $currentStatus == 'diterima' ? 'bg-success' : ($currentStatus == 'ditolak' ? 'bg-danger' : ($currentStatus == 'psikotes' ? 'bg-info' : 'bg-light')) }} {{ $isCompleted || $currentStatus == 'psikotes' ? 'text-white' : 'text-muted' }}">
                                                                        <i class="mdi {{ $currentStatus == 'diterima' ? 'mdi-check-circle' : ($currentStatus == 'ditolak' ? 'mdi-close-circle' : 'mdi-gavel') }}"></i>
                                                                    </div>
                                                                    <span class="ms-2 fw-medium">Keputusan</span>
                                                                </div>
                                                                
                                                                @if($currentStatus == 'psikotes' && !$isRecruiter)
                                                                    <div class="d-flex gap-1">
                                                                        <button type="button" class="btn btn-success btn-sm" 
                                                                                wire:click.prevent="setStatus({{ $lamaran->id }}, 'diterima')"
                                                                                title="Terima Kandidat">
                                                                            <i class="mdi mdi-check"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                                wire:click.prevent="setStatus({{ $lamaran->id }}, 'ditolak')"
                                                                                title="Tolak Kandidat">
                                                                            <i class="mdi mdi-close"></i>
                                                                        </button>
                                                                    </div>
                                                                @elseif($isCompleted)
                                                                    <span class="badge bg-{{ $currentStatus == 'diterima' ? 'success' : 'danger' }}">
                                                                        {{ ucfirst($currentStatus) }}
                                                                    </span>
                                                                @elseif($currentStatus != 'psikotes')
                                                                    <small class="text-muted">Setelah psikotes</small>
                                                                @endif
                                                            </div>
                                                        </div>
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
                            <input type="url" class="form-control" wire:model.defer="interviewLink" required>
                            @error('interviewLink') <div class="small text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu Pelaksanaan</label>
                            <input type="datetime-local" class="form-control" wire:model.defer="interviewWaktu" required>
                            @error('interviewWaktu') <div class="small text-danger">{{ $message }}</div> @enderror
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
    <div class="modal fade @if($detailModal) show @endif" tabindex="-1" style="@if($detailModal) display:block; @endif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kandidat</h5>
                    <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
                </div>
                <div class="modal-body">
                    @if($selectedKandidat)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Nama Lengkap</h6>
                                <p class="fw-medium">{{ $selectedKandidat->nama_depan }} {{ $selectedKandidat->nama_belakang }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Email</h6>
                                <p class="fw-medium">{{ optional($selectedKandidat->user)->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">No. KTP</h6>
                                <p class="fw-medium">{{ $selectedKandidat->no_ktp }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">No. NPWP</h6>
                                <p class="fw-medium">{{ $selectedKandidat->no_npwp ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Tempat & Tanggal Lahir</h6>
                                <p class="fw-medium">{{ $selectedKandidat->tempat_lahir }}, {{ optional($selectedKandidat->tanggal_lahir)->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Jenis Kelamin</h6>
                                <p class="fw-medium">{{ $selectedKandidat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Status Perkawinan</h6>
                                <p class="fw-medium">{{ $selectedKandidat->status_perkawinan }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">Agama</h6>
                                <p class="fw-medium">{{ $selectedKandidat->agama }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">No. Telepon</h6>
                                <p class="fw-medium">{{ $selectedKandidat->no_telpon }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-0">No. Telepon Alternatif</h6>
                                <p class="fw-medium">{{ $selectedKandidat->no_telpon_alternatif ?? '-' }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <h6 class="text-muted mb-0">Alamat</h6>
                                <p class="fw-medium">{{ $selectedKandidat->formatted_address }}</p>
                            </div>
                        </div>

                        <hr class="my-4" />

                        @php
                            $docLabels = [
                                'ktp' => 'KTP',
                                'ijazah' => 'Ijazah',
                                'sertifikat' => 'Sertifikat',
                                'surat_pengalaman' => 'Surat Pengalaman Kerja',
                                'skck' => 'SKCK',
                                'surat_sehat' => 'Surat Sehat',
                            ];
                        @endphp
                        <div class="row">
                            <div class="col-12 mb-2">
                                <h6 class="fw-bold text-primary"><i class="mdi mdi-file-upload-outline me-2"></i>Dokumen Pendukung</h6>
                            </div>
                            @foreach($docLabels as $key => $label)
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted mb-0">{{ $label }}</h6>
                                    @if(isset($documents[$key]))
                                        <a href="{{ Storage::url($documents[$key]) }}" target="_blank" class="d-block text-primary">
                                            <i class="mdi mdi-eye-outline me-1"></i>Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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

    .flow-step.completed .step-icon {
        background-color: #28a745 !important;
        color: white !important;
    }

    .flow-step.active .step-icon {
        background-color: #007bff !important;
        color: white !important;
    }

    .flow-step.disabled .step-icon {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        border: 2px solid #dee2e6;
    }

    .interview-details {
        margin-left: 44px;
        margin-top: 8px;
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
