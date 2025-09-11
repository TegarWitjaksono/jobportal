<div>
    {{-- Hero Section --}}
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Profil Saya</h5>
                        <p class="text-white-50 para-desc mx-auto mb-0">Lihat dan kelola data diri Anda di sini.</p>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    {{-- Shape Divider --}}
    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    {{-- Main Content --}}
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card border-0 shadow rounded">
                        <div class="card-header bg-primary p-4 d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-white mb-0">
                                <i class="mdi mdi-account-circle-outline me-2"></i>Informasi Profil
                            </h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-contrast-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit profil Anda">
                                    <i class="mdi mdi-pencil me-1"></i>Edit Profil
                                </a>
                                <button type="button" class="btn btn-sm btn-contrast-primary d-inline-flex align-items-center"
                                        wire:click="exportCv"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Export CV (ATS)" aria-label="Export CV (ATS)">
                                    <i class="mdi mdi-file-account-outline me-1"></i> Export CV
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            @if ($kandidat)
                                {{-- Data Test Section --}}
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-file-document me-2"></i>Data Tes
                                        </h6>
                                    </div>

                                    @if ($kandidat->bmi_score || $kandidat->blind_score)

                                        @if ($kandidat->bmi_score)
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-0">Skor BMI</h6>
                                            <p class="fw-medium fs-5">{{ $kandidat->bmi_score }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-0">Kategori BMI</h6>
                                            {{-- =================== INDIKATOR WARNA BMI =================== --}}
                                            <p class="fs-5">
                                                @switch($kandidat->bmi_category)
                                                    @case('Kurus')
                                                        <span class="badge bg-soft-warning">{{ $kandidat->bmi_category }}</span>
                                                        @break
                                                    @case('Normal')
                                                        <span class="badge bg-soft-success">{{ $kandidat->bmi_category }}</span>
                                                        @break
                                                    @case('Gemuk')
                                                        <span class="badge bg-soft-danger">{{ $kandidat->bmi_category }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-soft-secondary">{{ $kandidat->bmi_category }}</span>
                                                @endswitch
                                            </p>
                                            {{-- ========================================================= --}}
                                        </div>
                                        @endif

                                        @if ($kandidat->blind_score)
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-0">Skor Tes Buta Warna</h6>
                                            <p class="fw-medium fs-5">{{ $kandidat->blind_score }}%</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-0">Status Tes Buta Warna</h6>
                                            {{-- =================== INDIKATOR WARNA BUTA WARNA =================== --}}
                                            <p class="fs-5">
                                                @switch($kandidat->blind_test_status)
                                                    @case('Excellent')
                                                        <span class="badge bg-soft-success">{{ $kandidat->blind_test_status }}</span>
                                                        @break
                                                    @case('Good')
                                                        <span class="badge bg-soft-primary">{{ $kandidat->blind_test_status }}</span>
                                                        @break
                                                    @case('Fair')
                                                        <span class="badge bg-soft-warning">{{ $kandidat->blind_test_status }}</span>
                                                        @break
                                                    @case('Poor')
                                                        <span class="badge bg-soft-danger">{{ $kandidat->blind_test_status }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-soft-secondary">{{ $kandidat->blind_test_status }}</span>
                                                @endswitch
                                            </p>
                                            {{-- ============================================================== --}}
                                        </div>
                                        @endif

                                    @else
                                        <div class="col-12">
                                            <p class="text-muted">Belum ada hasil tes yang tersedia.</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-account-outline me-2"></i>Data Pribadi
                                        </h6>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Nama Lengkap</h6>
                                        <p class="fw-medium">{{ $kandidat->nama_depan }} {{ $kandidat->nama_belakang }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Email</h6>
                                        <p class="fw-medium">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">No. KTP</h6>
                                        <p class="fw-medium">{{ $kandidat->no_ktp }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">No. NPWP</h6>
                                        <p class="fw-medium">{{ $kandidat->no_npwp ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Tempat & Tanggal Lahir</h6>
                                        <p class="fw-medium">{{ $kandidat->tempat_lahir }}, {{ \Carbon\Carbon::parse($kandidat->tanggal_lahir)->isoFormat('D MMMM Y') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Jenis Kelamin</h6>
                                        <p class="fw-medium">{{ $kandidat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Status Perkawinan</h6>
                                        <p class="fw-medium">{{ $kandidat->status_perkawinan }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">Agama</h6>
                                        <p class="fw-medium">{{ $kandidat->agama }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">No. Telepon</h6>
                                        <p class="fw-medium">{{ $kandidat->no_telpon }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted mb-0">No. Telepon Alternatif</h6>
                                        <p class="fw-medium">{{ $kandidat->no_telpon_alternatif ?? '-' }}</p>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="text-muted mb-0">Alamat</h6>
                                        <p class="fw-medium">{{ $kandidat->alamat }}, {{ $kandidat->kode_pos }}, {{ $kandidat->negara }}</p>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <hr class="my-4">

                                {{-- Data Pendidikan & Kemampuan Section --}}
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-school-outline me-2"></i>Data Pendidikan & Kemampuan
                                        </h6>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <h6 class="text-muted mb-0">Pendidikan Tertinggi</h6>
                                        <p class="fw-medium">{{ $kandidat->pendidikan }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <h6 class="text-muted mb-0">Keahlian Lainnya</h6>
                                        <p class="fw-medium" style="white-space: pre-wrap;">{{ $kandidat->kemampuan ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-briefcase-outline me-2"></i>Riwayat Pengalaman Kerja
                                        </h6>
                                    </div>
@php
    $workData = $kandidat->riwayat_pengalaman_kerja ?? [];
    if (!is_array($workData)) {
        $workData = json_decode($workData, true) ?: [];
    }
@endphp
@if($workData)
    @foreach($workData as $item)
        <div class="col-12 mb-3">
            <p class="mb-0 fw-medium">{{ $item['position'] ?? '-' }} - {{ $item['company'] ?? '-' }}</p>
            <small class="text-muted">{{ $item['start'] ?? '-' }} - {{ $item['end'] ?? '-' }}</small>
            <p class="mb-0">Bisnis: {{ $item['business'] ?? '-' }}</p>
            <p class="mb-0">Alasan keluar: {{ $item['reason'] ?? '-' }}</p>
        </div>
    @endforeach
@else
    <div class="col-12"><p class="text-muted">Belum ada riwayat pengalaman kerja.</p></div>
@endif
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-school-outline me-2"></i>Riwayat Pendidikan
                                        </h6>
                                    </div>
                                    @php
                                        $eduData = $kandidat->riwayat_pendidikan ?? [];
                                        if (!is_array($eduData)) {
                                            $eduData = json_decode($eduData, true) ?: [];
                                        }
                                    @endphp
                                    @if($eduData)
                                        @foreach($eduData as $item)
                                            <div class="col-12 mb-3">
                                                <p class="mb-0 fw-medium">{{ $item['name'] ?? '-' }} - {{ $item['major'] ?? '-' }}</p>
                                                <small class="text-muted">{{ $item['start'] ?? '-' }} - {{ $item['end'] ?? '-' }}</small>
                                                <p class="mb-0">Tingkat: {{ $item['level'] ?? '-' }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12"><p class="text-muted">Belum ada riwayat pendidikan.</p></div>
                                    @endif
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-translate me-2"></i>Keterampilan Bahasa
                                        </h6>
                                    </div>
                                    @php
                                        $langData = $kandidat->kemampuan_bahasa ?? [];
                                        if (!is_array($langData)) {
                                            $langData = json_decode($langData, true) ?: [];
                                        }
                                    @endphp
                                    @if($langData)
                                        @foreach($langData as $item)
                                            <div class="col-12 mb-3">
                                                <p class="mb-0 fw-medium">{{ $item['language'] ?? '-' }}</p>
                                                <p class="mb-0">Berbicara: {{ $item['speaking'] ?? '-' }}, Membaca: {{ $item['reading'] ?? '-' }}, Menulis: {{ $item['writing'] ?? '-' }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12"><p class="text-muted">Belum ada keterampilan bahasa.</p></div>
                                    @endif
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-information-outline me-2"></i>Informasi Spesifik
                                        </h6>
                                    </div>
                                    @php
                                        $spec = $kandidat->informasi_spesifik ?? [];
                                        if (!is_array($spec)) {
                                            $spec = json_decode($spec, true) ?: [];
                                        }
                                    @endphp
                                    @if($spec)
                                        <div class="col-12">
                                            <p class="mb-1">Pernah bekerja di perusahaan ini? <strong>{{ $spec['pernah'] ?? '-' }}</strong></p>
                                            @if(isset($spec['pernah']) && $spec['pernah'] === 'Ya')
                                                <p class="mb-1">Lokasi: <strong>{{ $spec['lokasi'] ?? '-' }}</strong></p>
                                            @endif
        <p class="mb-0">Sumber informasi pekerjaan: <strong>{{ $spec['info'] ?? '-' }}</strong></p>
                                        </div>
                                    @else
                                        <div class="col-12"><p class="text-muted">Belum ada informasi spesifik.</p></div>
                                    @endif
                                </div>

                                {{-- Divider --}}
                                <hr class="my-4">

                                {{-- Dokumen Pendukung --}}
                                <div class="row">
                                    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-file-upload-outline me-2"></i>Dokumen Pendukung
                                        </h6>
                                        <button wire:click="openDocumentModal" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Unggah dokumen pendukung">
                                            <i class="mdi mdi-upload me-1"></i>Unggah Dokumen
                                        </button>
                                    </div>

@php
    $docs = [
        'ktp' => 'KTP',
        'ijazah' => 'Ijazah',
        'sertifikat' => 'Sertifikat',
        'surat_pengalaman' => 'Surat Pengalaman Kerja',
        'skck' => 'SKCK',
        'surat_sehat' => 'Surat Sehat',
    ];
@endphp

                                    @foreach ($docs as $key => $label)
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-0">{{ $label }}</h6>
                                            @if (isset($documents[$key]))
                                                <a href="{{ Storage::url($documents[$key]) }}" target="_blank" class="btn btn-sm btn-soft-primary d-inline-flex align-items-center" data-bs-toggle="tooltip" title="Lihat dokumen {{ $label }}">
                                                    <i class="mdi mdi-eye-outline me-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">Belum diunggah</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {{-- Pesan jika profil belum lengkap --}}
                                <div class="text-center py-5">
                                    <i class="mdi mdi-information-outline mdi-48px text-warning"></i>
                                    <h5 class="mt-3">Profil Anda Belum Lengkap</h5>
                                    <p class="text-muted">Silakan lengkapi profil Anda untuk melanjutkan proses rekrutmen.</p>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-2">
                                        <i class="mdi mdi-pencil me-1"></i>Lengkapi Profil Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Upload Dokumen --}}
    <div class="modal fade @if($showDocumentModal) show @endif" tabindex="-1" style="@if($showDocumentModal) display:block; @endif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="uploadDocuments">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            @if($documentType)
                                Ganti Dokumen {{ $docs[$documentType] ?? '' }}
                            @else
                                Unggah Dokumen Pendukung
                            @endif
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDocumentModal"></button>
                    </div>
                    <div class="modal-body">
                        @if(!$documentType || $documentType === 'ktp')
                        <div class="mb-3">
                            <label class="form-label">KTP</label>
                            @if(isset($documents['ktp']))
                                @php
                                    $path = ltrim($documents['ktp'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="KTP" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="ktp">
                            @if ($ktp)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($ktp->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['ktp'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $ktp->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                        @if(!$documentType || $documentType === 'ijazah')
                        <div class="mb-3">
                            <label class="form-label">Ijazah</label>
                            @if(isset($documents['ijazah']))
                                @php
                                    $path = ltrim($documents['ijazah'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="Ijazah" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="ijazah">
                            @if ($ijazah)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($ijazah->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['ijazah'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $ijazah->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                        @if(!$documentType || $documentType === 'sertifikat')
                        <div class="mb-3">
                            <label class="form-label">Sertifikat</label>
                            @if(isset($documents['sertifikat']))
                                @php
                                    $path = ltrim($documents['sertifikat'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="Sertifikat" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="sertifikat">
                            @if ($sertifikat)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($sertifikat->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['sertifikat'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $sertifikat->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                        @if(!$documentType || $documentType === 'surat_pengalaman')
                        <div class="mb-3">
                            <label class="form-label">Surat Pengalaman Kerja</label>
                            @if(isset($documents['surat_pengalaman']))
                                @php
                                    $path = ltrim($documents['surat_pengalaman'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="Surat Pengalaman" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="surat_pengalaman">
                            @if ($surat_pengalaman)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($surat_pengalaman->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['surat_pengalaman'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $surat_pengalaman->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                        @if(!$documentType || $documentType === 'skck')
                        <div class="mb-3">
                            <label class="form-label">SKCK</label>
                            @if(isset($documents['skck']))
                                @php
                                    $path = ltrim($documents['skck'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="SKCK" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="skck">
                            @if ($skck)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($skck->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['skck'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $skck->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                        @if(!$documentType || $documentType === 'surat_sehat')
                        <div class="mb-3">
                            <label class="form-label">Surat Sehat</label>
                            @if(isset($documents['surat_sehat']))
                                @php
                                    $path = ltrim($documents['surat_sehat'], '/');
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                    $url = $exists ? '/storage/' . $path : null;
                                @endphp
                                <div class="mb-2">
                                    @if($exists && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ $url }}" alt="Surat Sehat" class="img-fluid rounded border" style="max-height: 220px;">
                                    @elseif($exists && $ext === 'pdf')
                                        <iframe src="{{ $url }}" class="w-100" style="height: 400px; border:1px solid #e5e7eb; border-radius:6px;"></iframe>
                                    @elseif($exists)
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                            <i class="mdi mdi-file-download-outline me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <div class="small text-warning">Dokumen tidak ditemukan.</div>
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="surat_sehat">
                            @if ($surat_sehat)
                                <div class="mt-2">
                                    <span class="d-block">Preview:</span>
                                    @if(str_contains($surat_sehat->getMimeType(), 'pdf'))
                                        @php $previewPath = $tempPreview['surat_sehat'] ?? null; @endphp
                                        @if($previewPath)
                                            <iframe src="{{ Storage::url($previewPath) }}" class="w-100" style="height: 400px;"></iframe>
                                        @else
                                            <div class="small text-muted">Menyiapkan pratinjau PDF…</div>
                                        @endif
                                    @else
                                        <img src="{{ $surat_sehat->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;"/>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeDocumentModal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
