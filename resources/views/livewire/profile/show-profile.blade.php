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
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-light">
                                <i class="mdi mdi-pencil me-1"></i>Edit Profil
                            </a>
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
                                        <h6 class="text-muted mb-0">Pendidikan Terakhir</h6>
                                        <p class="fw-medium">{{ $kandidat->pendidikan }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <h6 class="text-muted mb-0">Pengalaman Kerja</h6>
                                        <p class="fw-medium" style="white-space: pre-wrap;">{{ $kandidat->pengalaman_kerja ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <h6 class="text-muted mb-0">Kemampuan Bahasa</h6>
                                        <p class="fw-medium" style="white-space: pre-wrap;">{{ $kandidat->kemampuan_bahasa ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <h6 class="text-muted mb-0">Keahlian Lainnya</h6>
                                        <p class="fw-medium" style="white-space: pre-wrap;">{{ $kandidat->kemampuan ?? '-' }}</p>
                                    </div>
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
</div>