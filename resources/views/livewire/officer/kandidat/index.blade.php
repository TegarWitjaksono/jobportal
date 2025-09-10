<div>
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Manajemen Kandidat</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manajemen Kandidat</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <!-- Filter dan Pencarian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kandidat..." wire:model.live="search">
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

            <!-- Tabel Kandidat -->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shadow rounded">
                        <table class="table table-center bg-white mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3">Nama Lengkap</th>
                                    <th class="border-bottom p-3">No. Telepon</th>
                                    <th class="border-bottom p-3">Email</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kandidats as $kandidat)
                                <tr>
                                    <td class="p-3">{{ $kandidat->getFullNameAttribute() }}</td>
                                    <td class="p-3">{{ $kandidat->no_telpon }}</td>
                                    <td class="p-3">{{ $kandidat->user->email }}</td>
                                    <td class="p-3">
                                        <span class="badge bg-soft-success">Aktif</span>
                                    </td>
                                    <td class="p-3">
                                        <button class="btn btn-sm btn-soft-primary me-1"
                                            wire:click="showDetail({{ $kandidat->id }})">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        
                                        <button class="btn btn-sm btn-soft-danger"
                                            wire:click="confirmDelete({{ $kandidat->id }})">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-3">Tidak ada data kandidat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $kandidats->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

            <!-- Modal Detail Kandidat -->
            @if($showDetailModal)
            <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 rounded shadow">
                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold">Detail Kandidat</h5>
                            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- Header kandidat dengan avatar --}}
                            <div class="d-flex align-items-center mb-3">
                                @php $photo = optional(optional($selectedKandidat)->user)->profile_photo_url ?? null; @endphp
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
                                        'KTP' => optional($selectedKandidat)->ktp_path,
                                        'Ijazah' => optional($selectedKandidat)->ijazah_path,
                                        'Sertifikat' => optional($selectedKandidat)->sertifikat_path,
                                        'Surat Pengalaman Kerja' => optional($selectedKandidat)->surat_pengalaman_path,
                                        'SKCK' => optional($selectedKandidat)->skck_path,
                                        'Surat Sehat' => optional($selectedKandidat)->surat_sehat_path,
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            
        </div>
    </section>
</div>
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('confirm-delete', (event) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data kandidat akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.deleteKandidat();
                    }
                });
            });
        });
    </script>
@endpush
