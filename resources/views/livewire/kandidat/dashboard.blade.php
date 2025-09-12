<div>
    <link rel="stylesheet" href="{{ asset('css/colorblind-test.css') }}">
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Dashboard Kandidat</h5>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
    
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 pb-2">
                    <div class="card border-0 text-center features feature-primary feature-clean rounded p-4 shadow h-100">
                        <div class="icons text-center mx-auto">
                            <i class="mdi mdi-briefcase-check-outline d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-4">
                            <h5 class="fw-bold">Lowongan Dilamar</h5>
                            <p class="text-muted">Lihat status semua lamaran pekerjaan yang telah Anda kirim.</p>
                            @auth
                                <a href="{{ route('kandidat.lowongan-dilamar') }}" class="read-more">Lihat Detail <i class="mdi mdi-arrow-right"></i></a>
                            @else
                                <a href="javascript:void(0)" onclick="promptAuth()" class="read-more">Lihat Detail <i class="mdi mdi-arrow-right"></i></a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 pb-2">
                    <div class="card border-0 text-center features feature-primary feature-clean rounded p-4 shadow h-100">
                        <div class="icons text-center mx-auto">
                            <i class="mdi mdi-file-document-edit-outline d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-4">
                            <h5 class="fw-bold">Tes Seleksi</h5>
                            <p class="text-muted">Kerjakan tes seleksi yang tersedia untuk melanjutkan proses rekrutmen.</p>
                            @auth
                                <a href="{{ route('cbt.dashboard') }}" class="read-more">Mulai Tes <i class="mdi mdi-arrow-right"></i></a>
                            @else
                                <a href="javascript:void(0)" onclick="promptAuth()" class="read-more">Mulai Tes <i class="mdi mdi-arrow-right"></i></a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 pb-2">
                    <div class="card border-0 text-center features feature-primary feature-clean rounded p-4 shadow h-100">
                        <div class="icons text-center mx-auto">
                            <i class="mdi mdi-account-cog-outline d-block rounded h3 mb-0"></i>
                        </div>
                        <div class="content mt-4">
                            <h5 class="fw-bold">Profil & Dokumen</h5>
                            <p class="text-muted">Pastikan profil dan dokumen Anda selalu lengkap dan terbaru.</p>
                            @auth
                                <a href="{{ route('profile.show') }}" class="read-more">Update Profil <i class="mdi mdi-arrow-right"></i></a>
                            @else
                                <a href="javascript:void(0)" onclick="promptAuth()" class="read-more">Update Profil <i class="mdi mdi-arrow-right"></i></a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Lowongan Terbaru</h4>
                        <a href="{{ route('jobs.browse') }}" class="btn btn-link">Lihat Semua Lowongan <i class="mdi mdi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            {{-- Bagian lowongan terbaru --}}
<div class="row g-3">
    @php
        $kolomClass = 'col-sm-6 col-lg-4 col-xl-3'; // Responsive: 1 di xs, 2 di sm, 3 di lg, 4 di xl
    @endphp
    
    @forelse($lowonganTerbaru as $lowongan)
    <div class="{{ $kolomClass }}">
        <div class="card job-box border-0 rounded-3 shadow-sm h-100 hover-shadow">
            <div class="card-body p-3 d-flex flex-column">
                <!-- Image Container -->
                <div class="mb-3 position-relative rounded-3 overflow-hidden" style="height: 120px; background-color: #f8f9fa;">
                    @if($lowongan->foto)
                        <img src="{{ asset('storage/image/lowongan/' . $lowongan->foto) }}" 
                             alt="Foto Lowongan" 
                             class="img-fluid w-100 h-100" 
                             style="object-fit: contain; object-position: center;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <div class="text-center text-muted">
                                <i class="mdi mdi-briefcase-outline" style="font-size: 2rem;"></i>
                                <div class="small mt-1">No Image</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Area (flex-grow-1 to push button to bottom) -->
                <div class="flex-grow-1">
                    <!-- Job Title and Type Badge -->
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <h6 class="mb-0 fw-semibold lh-sm">
                            <a href="#" 
                               wire:click.prevent="showJob({{ $lowongan->id }})" 
                               class="text-dark text-decoration-none stretched-link"
                               style="font-size: 0.95rem;">
                                {{ Str::limit($lowongan->nama_posisi, 40) }}
                            </a>
                        </h6>
                        <span class="badge rounded-pill ms-2 flex-shrink-0 {{ $lowongan->is_remote ? 'bg-success' : 'bg-primary' }}"
                              style="font-size: 0.7rem;">
                            {{ $lowongan->is_remote ? 'Remote' : 'Fulltime' }}
                        </span>
                    </div>

                    <!-- Job Details -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1 text-muted" style="font-size: 0.8rem;">
                            <i class="mdi mdi-domain me-2" style="font-size: 0.9rem;"></i>
                            <span class="text-truncate">{{ Str::limit($lowongan->departemen, 25) }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-1 text-muted" style="font-size: 0.8rem;">
                            <i class="mdi mdi-map-marker me-2" style="font-size: 0.9rem;"></i>
                            <span class="text-truncate">{{ Str::limit($lowongan->lokasi_penugasan, 25) }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted" style="font-size: 0.8rem;">
                            <i class="mdi mdi-cash-multiple me-2" style="font-size: 0.9rem;"></i>
                            <span class="fw-medium">{{ $lowongan->range_gaji }} Juta</span>
                        </div>
                    </div>

                    <!-- Category and Deadline Badges -->
                    <div class="d-flex flex-column gap-1">
                        @if(optional($lowongan->kategoriLowongan)->nama_kategori)
                        <span class="badge bg-soft-primary text-primary align-self-start">
                            {{ Str::limit(optional($lowongan->kategoriLowongan)->nama_kategori) }}
                        </span>
                        @endif
                        <span class="badge bg-soft-warning text-warning align-self-start">
                            {{ \Carbon\Carbon::parse($lowongan->tanggal_berakhir)->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <!-- Apply Button (positioned at bottom) -->
                <div class="pt-2 border-top">
                    <button type="button" 
                            wire:click.prevent="showJob({{ $lowongan->id }})" 
                            class="btn btn-primary btn-sm w-100 position-relative"
                            style="z-index: 10; font-size: 0.85rem;">
                        <i class="mdi mdi-send me-1"></i>Lamar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center border-0 rounded-3 bg-light">
            <div class="py-4">
                <i class="mdi mdi-information-outline text-info mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-info mb-2">Belum Ada Lowongan</h5>
                <p class="text-muted mb-0">Belum ada lowongan tersedia saat ini. Silakan cek kembali nanti.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

            {{-- Link paginasi --}}
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end">
                        {{ $lowonganTerbaru->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alert Messages --}}
    @if (session()->has('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1061">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1061">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- MODAL 1: Untuk Detail Lowongan --}}
    @if($showJobModal && $selectedLowongan)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header p-4">
                    <h5 class="modal-title fw-bold">{{ $selectedLowongan->nama_posisi }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 bg-light rounded p-1" style="width: 80px; height: 80px;">
                            @if($selectedLowongan->foto)
                                <img src="{{ asset('storage/image/lowongan/' . $selectedLowongan->foto) }}" alt="Foto Lowongan" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="mdi mdi-image-area" style="font-size: 40px; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">{{ optional($selectedLowongan->kategoriLowongan)->nama_kategori }}</h6>
                            <p class="text-muted mb-0"><i class="mdi mdi-office-building-outline me-1"></i>{{ $selectedLowongan->departemen }}</p>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold">Deskripsi Pekerjaan</h6>
                    <div class="text-muted job-description">
                        {!! $selectedLowongan->deskripsi !!}
                    </div>

                    <h6 class="fw-bold mt-4">Kemampuan yang Dibutuhkan</h6>
                    <p class="text-muted">{{ $selectedLowongan->kemampuan_yang_dibutuhkan }}</p>
                </div>
                <div class="modal-footer p-3 bg-light">
                    <button type="button" class="btn btn-soft-secondary" wire:click="closeModal">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="applyJob({{ $selectedLowongan->id }})">
                        Lamar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- MODAL BMI TEST: Untuk Tes BMI --}}
    @if($showBmiTestModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <form wire:submit.prevent="calculateBmi" class="modal-content rounded shadow-lg">
                <div class="modal-header p-4 bg-soft-primary text-primary border-0 rounded-top-3">
                    <h5 class="modal-title fw-bold d-flex align-items-center mb-0">
                        <i class="mdi mdi-weight-kilogram me-2"></i>
                        Tes BMI (Body Mass Index)
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeBmiTest" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info bg-soft-info border-0 text-info">
                        <i class="mdi mdi-information-outline me-2"></i>
                        Silakan masukkan tinggi dan berat badan Anda untuk melanjutkan proses.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tinggi Badan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="1" min="100" max="250" class="form-control @error('tinggi_badan') is-invalid @enderror" 
                                   wire:model="tinggi_badan" placeholder="Masukkan tinggi badan">
                            <span class="input-group-text">cm</span>
                        </div>
                        <div class="small text-muted mt-1">Rentang disarankan: 100–250 cm</div>
                        @error('tinggi_badan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Berat Badan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.1" min="30" max="200" class="form-control @error('berat_badan') is-invalid @enderror" 
                                   wire:model="berat_badan" placeholder="Masukkan berat badan">
                            <span class="input-group-text">kg</span>
                        </div>
                        <div class="small text-muted mt-1">Rentang disarankan: 30–200 kg</div>
                        @error('berat_badan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-0 rounded-bottom-3">
                    <button type="button" class="btn btn-soft-secondary" wire:click="closeBmiTest">Batal</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="calculateBmi">
                            <i class="mdi mdi-arrow-right me-1"></i>Lanjutkan
                        </span>
                        <span wire:loading wire:target="calculateBmi">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- MODAL BLIND TEST: Untuk Tes Buta Warna --}}
    @if($showBlindTestModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header p-3 bg-soft-primary text-primary border-0 rounded-top-3">
                    <h5 class="modal-title fw-bold d-flex align-items-center mb-0">
                        <i class="mdi mdi-eye-outline me-2"></i>
                        Tes Buta Warna
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeBlindTest" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="progress mb-3 bg-light rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" 
                            style="width: {{ ($current_blind_test / $total_blind_tests) * 100 }}%" 
                            aria-valuenow="{{ ($current_blind_test / $total_blind_tests) * 100 }}" 
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <div class="small text-muted mb-1">Soal {{ $current_blind_test }} dari {{ $total_blind_tests }}</div>
                        @php
                            $fileName = 'bt' . $current_blind_test . '.jpg';
                            $fullPath = public_path('storage/image/colorblind/' . $fileName);
                            $imgSrc = file_exists($fullPath)
                                ? asset('storage/image/colorblind/' . $fileName)
                                : null;
                        @endphp
                        @if($imgSrc)
                            <div class="d-inline-block bg-white rounded shadow-sm p-1 border" style="max-width: 300px;">
                                <img src="{{ $imgSrc }}" alt="Color Blind Test Image" class="img-fluid rounded" style="max-width: 260px;">
                            </div>
                        @else
                            <div class="alert alert-warning p-2 d-inline-block">Gambar tidak ditemukan di storage/image/colorblind ({{ $fileName }})</div>
                        @endif
                    </div>

                    <div class="d-flex align-items-center small text-muted mb-2">
                        <i class="mdi mdi-information-outline me-1"></i>
                        <span>Pilih angka yang Anda lihat pada gambar di atas.</span>
                    </div>

                    <div class="row g-2 mt-1">
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                        <div class="col-6">
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm w-100 py-2 px-3 d-flex align-items-center justify-content-between"
                                    wire:click="submitBlindTestAnswer('{{ $option }}')"
                                    wire:loading.attr="disabled" wire:target="submitBlindTestAnswer">
                                <span class="d-flex align-items-center">
                                    <span class="me-2 d-inline-flex align-items-center justify-content-center bg-soft-primary text-primary rounded-circle"
                                          style="width: 28px; height: 28px; font-weight: 700; font-size: 12px;">{{ $option }}</span>
                                    <span class="fw-semibold" style="font-size: 14px;">{{ $blind_test_options[$option] ?? '' }}</span>
                                </span>
                                <i class="mdi mdi-chevron-right"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer p-2 bg-light border-0 rounded-bottom-3">
                    <button type="button" class="btn btn-soft-secondary" wire:click="closeBlindTest">Batal</button>
                    <small class="text-muted" wire:loading.remove wire:target="submitBlindTestAnswer">Klik salah satu pilihan untuk lanjut</small>
                    <small class="text-muted d-flex align-items-center" wire:loading wire:target="submitBlindTestAnswer">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Menyimpan jawaban...
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- MODAL RESULT TEST: Tampilkan Hasil Tes dari Cache --}}
    @if($showResultModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header p-4 bg-soft-primary text-primary border-0 rounded-top-3">
                    <h5 class="modal-title fw-bold d-flex align-items-center mb-0">
                        <i class="mdi mdi-clipboard-check-outline me-2"></i>
                        Hasil Tes
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeResultModal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @php
                        $bmiInvalid = isset($testResults['bmi']) && ($testResults['bmi']['kategori'] ?? '') !== 'Normal';
                        $blindInvalid = isset($testResults['blind']) && (int)($testResults['blind']['score'] ?? 0) < 60;
                    @endphp

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <div class="border rounded-3 p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="mdi mdi-scale me-2"></i>
                                        <span class="fw-semibold">BMI</span>
                                    </div>
                                    @if(isset($testResults['bmi']))
                                        @php($bmiCat = $testResults['bmi']['kategori'] ?? '-')
                                        <span class="badge {{ $bmiInvalid ? 'bg-soft-danger text-danger' : 'bg-soft-success text-success' }}">{{ $bmiCat }}</span>
                                    @endif
                                </div>
                                @if(isset($testResults['bmi']))
                                    <div class="fs-5 fw-bold">{{ $testResults['bmi']['score'] }}</div>
                                    <small class="text-muted">Kategori: {{ $testResults['bmi']['kategori'] }}</small>
                                @else
                                    <small class="text-muted">Belum ada data BMI.</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-3 p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="mdi mdi-eye-check-outline me-2"></i>
                                        <span class="fw-semibold">Tes Buta Warna</span>
                                    </div>
                                    @if(isset($testResults['blind']))
                                        @php($blindScore = (int)($testResults['blind']['score'] ?? 0))
                                        <span class="badge {{ $blindInvalid ? 'bg-soft-danger text-danger' : 'bg-soft-success text-success' }}">{{ $blindScore }}%</span>
                                    @endif
                                </div>
                                @if(isset($testResults['blind']))
                                    <div class="fs-5 fw-bold">{{ (int)($testResults['blind']['score'] ?? 0) }}%</div>
                                    <small class="text-muted">Minimal lulus: 60%</small>
                                @else
                                    <small class="text-muted">Belum ada data tes buta warna.</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($bmiInvalid)
                        <div class="alert bg-soft-danger text-danger border-0">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                            Hasil BMI Anda tidak memenuhi syarat pendaftaran.
                        </div>
                    @endif
                    @if($blindInvalid)
                        <div class="alert bg-soft-danger text-danger border-0">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                            Hasil tes buta warna Anda tidak memenuhi syarat pendaftaran.
                        </div>
                    @endif
                    @if($bmiInvalid || $blindInvalid)
                        <div class="alert bg-soft-warning text-warning border-0">
                            <i class="mdi mdi-alert-outline me-2"></i>
                            Anda tidak dapat melanjutkan tahap registrasi.
                        </div>
                    @endif
                </div>
                <div class="modal-footer p-3 bg-light border-0 rounded-bottom-3">
                    @if(!$bmiInvalid && !$blindInvalid)
                        <button type="button" class="btn btn-primary" wire:click="closeResultModal">
                            <i class="mdi mdi-arrow-right me-1"></i> Lanjutkan
                        </button>
                    @else
                        <button type="button" class="btn btn-soft-secondary" wire:click="closeResultModal">Tutup</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- MODAL PROFILE: Untuk Lengkapi Data Profil --}}
    @if($showProfileModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header p-4">
                    <h5 class="modal-title fw-bold">Lengkapi Data Profil</h5>
                    <button type="button" class="btn-close" wire:click="closeProfileForm" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info">
                        <i class="mdi mdi-information-outline me-2"></i>
                        Harap lengkapi data diri Anda terlebih dahulu untuk melanjutkan proses lamaran.
                    </div>
                    
                    <form wire:submit.prevent="saveProfile">
                        <div class="row">
                            {{-- Data Pribadi --}}
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Data Pribadi</h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_depan') is-invalid @enderror" 
                                    wire:model="nama_depan" placeholder="Masukkan nama depan">
                                @error('nama_depan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_belakang') is-invalid @enderror" 
                                    wire:model="nama_belakang" placeholder="Masukkan nama belakang">
                                @error('nama_belakang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telpon') is-invalid @enderror" 
                                    wire:model="no_telpon" placeholder="Masukkan nomor telepon">
                                @error('no_telpon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon Alternatif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telpon_alternatif') is-invalid @enderror" 
                                    wire:model="no_telpon_alternatif" placeholder="Masukkan nomor telepon alternatif">
                                @error('no_telpon_alternatif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. KTP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" 
                                    wire:model="no_ktp" placeholder="Masukkan nomor KTP">
                                @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                    wire:model="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" 
                                    wire:model="kode_pos" placeholder="Masukkan kode pos">
                                @error('kode_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Negara <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('negara') is-invalid @enderror" 
                                    wire:model="negara" placeholder="Masukkan negara" value="Indonesia">
                                @error('negara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                    wire:model="tempat_lahir" placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                    wire:model="tanggal_lahir">
                                @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    wire:model="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_perkawinan') is-invalid @enderror" 
                                    wire:model="status_perkawinan">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                                @error('status_perkawinan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agama <span class="text-danger">*</span></label>
                                <select class="form-select @error('agama') is-invalid @enderror" 
                                    wire:model="agama">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                                @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. NPWP</label>
                                <input type="text" class="form-control @error('no_npwp') is-invalid @enderror" 
                                    wire:model="no_npwp" placeholder="Masukkan nomor NPWP (opsional)">
                                @error('no_npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            {{-- Data Hasil Tes (Tampilkan jika sudah ada) --}}
                            @if(Auth::user()->kandidat && (Auth::user()->kandidat->bmi_score || Auth::user()->kandidat->blind_score))
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Hasil Tes</h6>
                            </div>
                            
                            @if(Auth::user()->kandidat->bmi_score)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BMI Score</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ Auth::user()->kandidat->bmi_score }}" readonly>
                                    <span class="input-group-text">{{ Auth::user()->kandidat->bmi_category }}</span>
                                </div>
                            </div>
                            @endif

                            @if(Auth::user()->kandidat->blind_score)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Blind Test Score</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ Auth::user()->kandidat->blind_score }}" readonly>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            @endif
                            @endif
                            
                            {{-- Data Pendidikan & Kemampuan --}}
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Data Pendidikan & Kemampuan</h6>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <select class="form-select @error('pendidikan') is-invalid @enderror" 
                                    wire:model="pendidikan">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                @error('pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Pengalaman Kerja</label>
                                <textarea class="form-control" wire:model="pengalaman_kerja" 
                                    rows="3" placeholder="Deskripsikan pengalaman kerja Anda (opsional)"></textarea>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Kemampuan Bahasa</label>
                                <textarea class="form-control" wire:model="kemampuan_bahasa" 
                                    rows="2" placeholder="Sebutkan bahasa yang Anda kuasai (opsional)"></textarea>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Kemampuan Lainnya</label>
                                <textarea class="form-control" wire:model="kemampuan" 
                                    rows="3" placeholder="Sebutkan kemampuan lain yang Anda miliki (opsional)"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer p-3 bg-light">
                    <button type="button" class="btn btn-soft-secondary" wire:click="closeProfileForm">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="saveProfile"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="saveProfile">
                            <i class="mdi mdi-content-save me-1"></i>Simpan Data
                        </span>
                        <span wire:loading wire:target="saveProfile">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    @push('scripts')
    @guest
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk menampilkan pop-up pilihan otentikasi
        function showAuthPrompt() {
            Swal.fire({
                title: 'Tes Selesai!',
                text: "Silakan login untuk melanjutkan atau daftar untuk menyimpan progres Anda.",
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: '<i class="mdi mdi-account-plus-outline me-1"></i> Daftar Akun Baru',
                cancelButtonText: '<i class="mdi mdi-login me-1"></i> Login',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                reverseButtons: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Arahkan ke halaman register
                    window.location.href = "{{ route('register') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Arahkan ke halaman login
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        function promptAuth() {
            const cached = localStorage.getItem('guestTestResults');
            if (cached) {
                const data = JSON.parse(cached);
                const bmiInvalid = data.bmi && data.bmi.kategori !== 'Normal';
                const blindInvalid = data.blind && data.blind.score < 60;

                if (bmiInvalid || blindInvalid) {
                    Swal.fire({
                        title: 'Tidak memenuhi syarat',
                        text: 'Anda tidak dapat melanjutkan registrasi.',
                        icon: 'error'
                    });
                    return;
                }
            }

            showAuthPrompt();
        }

        document.addEventListener('livewire:initialized', () => {
            // Menunggu sinyal 'prompt-auth-after-test' dari backend
            @this.on('prompt-auth-after-test', () => {
                showAuthPrompt(); // Tampilkan pop-up
            });

            @this.on('store-test-results', (data) => {
                localStorage.setItem('guestTestResults', JSON.stringify(data));
            });

            @this.on('clear-test-data', () => {
                localStorage.removeItem('guestTestResults');
            });

            const cached = localStorage.getItem('guestTestResults');
            if (cached) {
                Livewire.dispatch('show-cached-results', JSON.parse(cached));
            }

            // Auto-start guest test flow when requested via query string
            const params = new URLSearchParams(window.location.search);
            if (params.get('start_test') === '1') {
                Livewire.dispatch('start-guest-test-flow');
            }
        });
    </script>
    @else
    <script>
        document.addEventListener('livewire:initialized', () => {
            localStorage.removeItem('guestTestResults');
        });
    </script>
    @endguest
    @endpush
</div>
