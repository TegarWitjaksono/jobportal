<div>
    {{-- Hero Section --}}
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Informasi Detail Kandidat') }}</h5>
                        <p class="text-white-50 para-desc mx-auto mb-0">{{ __('Lengkapi atau perbarui informasi detail profil Anda. Data ini akan digunakan dalam proses rekrutmen.') }}</p>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
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
                <div class="col-12">
                    {{-- Form Card --}}
                    <div class="card border-0 shadow rounded">
                        <div class="card-header bg-primary p-4">
                            <h5 class="card-title text-white mb-0">
                                <i class="mdi mdi-account-edit-outline me-2"></i>{{ __('Informasi Detail Kandidat') }}
                            </h5>
                            <p class="text-white-50 mb-0 mt-1">{{ __('Lengkapi atau perbarui informasi detail profil Anda. Data ini akan digunakan dalam proses rekrutmen.') }}</p>
                        </div>
                        
                        <form id="kandidat-form" wire:submit.prevent="updateKandidatProfile" class="card-body p-4">
                            {{-- Bagian hasil tes disembunyikan pada halaman edit --}}
                            {{-- Data Pribadi Section --}}
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <h6 class="fw-bold text-primary border-bottom pb-2">
                                        <i class="mdi mdi-account-outline me-2"></i>Data Pribadi
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama_depan" class="form-label">{{ __('Nama Depan') }} <span class="text-danger">*</span></label>
                                    <input id="nama_depan" type="text" class="form-control @error('state.nama_depan') is-invalid @enderror" 
                                        wire:model.defer="state.nama_depan" autocomplete="given-name" placeholder="Masukkan nama depan">
                                    @error('state.nama_depan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nama_belakang" class="form-label">{{ __('Nama Belakang') }} <span class="text-danger">*</span></label>
                                    <input id="nama_belakang" type="text" class="form-control @error('state.nama_belakang') is-invalid @enderror" 
                                        wire:model.defer="state.nama_belakang" autocomplete="family-name" placeholder="Masukkan nama belakang">
                                    @error('state.nama_belakang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_ktp" class="form-label">{{ __('No. KTP') }} <span class="text-danger">*</span></label>
                                    <input id="no_ktp" type="text" class="form-control @error('state.no_ktp') is-invalid @enderror" 
                                        wire:model.defer="state.no_ktp" placeholder="Masukkan nomor KTP">
                                    @error('state.no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_npwp" class="form-label">{{ __('No. NPWP (Opsional)') }}</label>
                                    <input id="no_npwp" type="text" class="form-control @error('state.no_npwp') is-invalid @enderror" 
                                        wire:model.defer="state.no_npwp" placeholder="Masukkan nomor NPWP (opsional)">
                                    @error('state.no_npwp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">{{ __('Tempat Lahir') }} <span class="text-danger">*</span></label>
                                    <input id="tempat_lahir" type="text" class="form-control @error('state.tempat_lahir') is-invalid @enderror" 
                                        wire:model.defer="state.tempat_lahir" placeholder="Masukkan tempat lahir">
                                    @error('state.tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">{{ __('Tanggal Lahir') }} <span class="text-danger">*</span></label>
                                    <input id="tanggal_lahir" type="date" class="form-control @error('state.tanggal_lahir') is-invalid @enderror" 
                                        wire:model.defer="state.tanggal_lahir">
                                    @error('state.tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telpon" class="form-label">{{ __('No. Telepon') }} <span class="text-danger">*</span></label>
                                    <input id="no_telpon" type="text" class="form-control @error('state.no_telpon') is-invalid @enderror" 
                                        wire:model.defer="state.no_telpon" placeholder="Masukkan nomor telepon">
                                    @error('state.no_telpon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="no_telpon_alternatif" class="form-label">{{ __('No. Telepon Alternatif') }}</label>
                                    <input id="no_telpon_alternatif" type="text" class="form-control @error('state.no_telpon_alternatif') is-invalid @enderror" 
                                        wire:model.defer="state.no_telpon_alternatif" placeholder="Masukkan nomor telepon alternatif">
                                    @error('state.no_telpon_alternatif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="alamat" class="form-label">{{ __('Alamat Lengkap') }} <span class="text-danger">*</span></label>
                                    <textarea id="alamat" class="form-control @error('state.alamat') is-invalid @enderror" 
                                        wire:model.defer="state.alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                                    @error('state.alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">{{ __('Kode Pos') }} <span class="text-danger">*</span></label>
                                    <input id="kode_pos" type="text" class="form-control @error('state.kode_pos') is-invalid @enderror" 
                                        wire:model.defer="state.kode_pos" placeholder="Masukkan kode pos">
                                    @error('state.kode_pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="negara" class="form-label">{{ __('Negara') }} <span class="text-danger">*</span></label>
                                    @php $countries = config('countries'); @endphp
                                    <select id="negara" class="form-select @error('state.negara') is-invalid @enderror" wire:model.defer="state.negara" required>
                                        <option value="">{{ __('Pilih Negara') }}</option>
                                        @foreach($countries as $code => $country)
                                            @php $flag = mb_chr(127397 + ord($code[0])) . mb_chr(127397 + ord($code[1])); @endphp
                                            <option value="{{ $country }}">{{ $flag }} {{ $country }}</option>
                                        @endforeach
                                    </select>
                                    @error('state.negara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="jenis_kelamin" class="form-label">{{ __('Jenis Kelamin') }} <span class="text-danger">*</span></label>
                                    <select id="jenis_kelamin" wire:model.defer="state.jenis_kelamin" class="form-select @error('state.jenis_kelamin') is-invalid @enderror">
                                        <option value="">Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('state.jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="status_perkawinan" class="form-label">{{ __('Status Perkawinan') }} <span class="text-danger">*</span></label>
                                    <select id="status_perkawinan" wire:model.defer="state.status_perkawinan" class="form-select @error('state.status_perkawinan') is-invalid @enderror">
                                        <option value="">Pilih...</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Cerai">Cerai</option>
                                    </select>
                                    @error('state.status_perkawinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="agama" class="form-label">{{ __('Agama') }} <span class="text-danger">*</span></label>
                                    <select id="agama" wire:model.defer="state.agama" class="form-select @error('state.agama') is-invalid @enderror">
                                        <option value="">Pilih...</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                    @error('state.agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold"><i class="mdi mdi-briefcase-outline me-2"></i>Riwayat Pengalaman Kerja</label>
                                    <div id="work-experience-list"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-work-experience">
                                        <i class="mdi mdi-plus"></i> Tambah Pengalaman
                                    </button>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold"><i class="mdi mdi-school-outline me-2"></i>Riwayat Pendidikan</label>
                                    <div id="education-list"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-education">
                                        <i class="mdi mdi-plus"></i> Tambah Pendidikan
                                    </button>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold"><i class="mdi mdi-translate me-2"></i>Keterampilan Bahasa</label>
                                    <div id="language-list"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-language">
                                        <i class="mdi mdi-plus"></i> Tambah Bahasa
                                    </button>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold"><i class="mdi mdi-information-outline me-2"></i>Informasi Spesifik</label>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Pernah bekerja di Perusahaan ini?</label>
                                            <select id="pernah-bekerja" class="form-select">
                                                <option value="Tidak">Tidak</option>
                                                <option value="Ya">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="lokasi-wrapper" style="display:none;">
                                            <label>Jika ya, di Lokasi mana anda bekerja?</label>
                                            <input type="text" class="form-control" id="lokasi-bekerja" placeholder="Masukkan lokasi">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Bagaimana anda menpatkan informasi pekerjaan ini?</label>
                                            <input type="text" class="form-control" id="info-lowongan" placeholder="Contoh: Website perusahaan, teman, iklan">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" wire:model.defer="state.riwayat_pengalaman_kerja" id="riwayat_pengalaman_kerja">
                                <input type="hidden" wire:model.defer="state.riwayat_pendidikan" id="riwayat_pendidikan">
                                <input type="hidden" wire:model.defer="state.kemampuan_bahasa" id="kemampuan_bahasa">
                                <input type="hidden" wire:model.defer="state.informasi_spesifik" id="informasi_spesifik">

                                <div class="col-12 mb-3">
                                    <label for="kemampuan" class="form-label">{{ __('Keahlian (Opsional)') }}</label>
                                    <textarea id="kemampuan" class="form-control @error('state.kemampuan') is-invalid @enderror"
                                        wire:model.defer="state.kemampuan" rows="4"
                                        placeholder="Sebutkan keahlian yang Anda miliki, seperti bahasa pemrograman, software, sertifikasi, dll"></textarea>
                                    <small class="text-muted">Contoh: JavaScript, PHP, Laravel, MySQL, Adobe Photoshop, Google Analytics</small>
                                    @error('state.kemampuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <template id="work-experience-template">
                                <div class="work-experience-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="work_start[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" class="form-control" name="work_end[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Nama Perusahaan</label>
                                            <input type="text" class="form-control" name="company_name[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Keterangan Bisnis Perusahaan</label>
                                            <input type="text" class="form-control" name="company_business[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Jabatan</label>
                                            <input type="text" class="form-control" name="position[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Alasan keluar/berhenti</label>
                                            <input type="text" class="form-control" name="reason[]">
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-work-experience">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template id="education-template">
                                <div class="education-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="edu_start[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Tanggal Berakhir</label>
                                            <input type="date" class="form-control" name="edu_end[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Nama Pendidikan</label>
                                            <input type="text" class="form-control" name="edu_name[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Jurusan</label>
                                            <input type="text" class="form-control" name="edu_major[]">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Tingkat Pendidikan</label>
                                            <select class="form-select" name="edu_level[]">
                                                <option value="">Pilih...</option>
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
                                                <option value="Post Doktoral">Post Doktoral</option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-education">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template id="language-template">
                                <div class="language-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label>Bahasa</label>
                                            <input type="text" class="form-control" name="language_name[]">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Kemahiran Berbicara</label>
                                            <select class="form-select" name="speaking[]">
                                                <option value="">Pilih...</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Kemahiran Membaca</label>
                                            <select class="form-select" name="reading[]">
                                                <option value="">Pilih...</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Kemahiran Menulis</label>
                                            <select class="form-select" name="writing[]">
                                                <option value="">Pilih...</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-language">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Action Buttons --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                        {{-- Success Message --}}
                                        <div class="flex-grow-1">
                                            <div wire:loading.remove wire:target="updateKandidatProfile">
                                                @if (session()->has('message'))
                                                    <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                                                        <i class="mdi mdi-check-circle-outline me-2"></i>
                                                        {{ session('message') }}
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            {{-- Loading State --}}
                                            <div wire:loading wire:target="updateKandidatProfile">
                                                <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
                                                    <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
                                                    Menyimpan data...
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- Buttons --}}
                                        <a href="{{ route('profile.show') }}" class="btn btn-soft-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i>{{ __('Kembali') }}
                                        </a>
                                        
                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="updateKandidatProfile">
                                                <i class="mdi mdi-content-save me-1"></i>{{ __('Simpan') }}
                                            </span>
                                            <span wire:loading wire:target="updateKandidatProfile">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Menyimpan...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alert Messages (Fixed Position) --}}
    @if (session()->has('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1061">
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                <i class="mdi mdi-check-circle-outline me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1061">
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                <i class="mdi mdi-alert-circle-outline me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Scripts for dynamic form and alerts --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // ===== Dynamic Work Experience =====
            const workList = document.getElementById('work-experience-list');
            document.getElementById('add-work-experience').addEventListener('click', () => {
                const tmpl = document.getElementById('work-experience-template').content.cloneNode(true);
                workList.appendChild(tmpl);
            });
            workList.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-work-experience')) {
                    e.target.closest('.work-experience-item').remove();
                }
            });

            // ===== Dynamic Education =====
            const eduList = document.getElementById('education-list');
            document.getElementById('add-education').addEventListener('click', () => {
                const tmpl = document.getElementById('education-template').content.cloneNode(true);
                eduList.appendChild(tmpl);
            });
            eduList.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-education')) {
                    e.target.closest('.education-item').remove();
                }
            });

            // ===== Dynamic Language =====
            const langList = document.getElementById('language-list');
            document.getElementById('add-language').addEventListener('click', () => {
                const tmpl = document.getElementById('language-template').content.cloneNode(true);
                langList.appendChild(tmpl);
            });
            langList.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-language')) {
                    e.target.closest('.language-item').remove();
                }
            });

            // ===== Specific Info =====
            const pernah = document.getElementById('pernah-bekerja');
            const lokasiWrapper = document.getElementById('lokasi-wrapper');
            pernah.addEventListener('change', () => {
                lokasiWrapper.style.display = (pernah.value === 'Ya') ? 'block' : 'none';
                if (pernah.value !== 'Ya') {
                    document.getElementById('lokasi-bekerja').value = '';
                }
            });

            // Seed localStorage with data from server if empty
            const initialWork = @json($state['riwayat_pengalaman_kerja'] ? json_decode($state['riwayat_pengalaman_kerja'], true) : []);
            if (!localStorage.getItem('work_experiences') && initialWork.length) {
                localStorage.setItem('work_experiences', JSON.stringify(initialWork));
            }
            const initialEdu = @json($state['riwayat_pendidikan'] ? json_decode($state['riwayat_pendidikan'], true) : []);
            if (!localStorage.getItem('education_history') && initialEdu.length) {
                localStorage.setItem('education_history', JSON.stringify(initialEdu));
            }
            const initialLang = @json($state['kemampuan_bahasa'] ? json_decode($state['kemampuan_bahasa'], true) : []);
            if (!localStorage.getItem('language_skills') && initialLang.length) {
                localStorage.setItem('language_skills', JSON.stringify(initialLang));
            }
            const initialSpec = @json($state['informasi_spesifik'] ? json_decode($state['informasi_spesifik'], true) : []);
            if (!localStorage.getItem('specific_info') && Object.keys(initialSpec).length) {
                localStorage.setItem('specific_info', JSON.stringify(initialSpec));
            }

            // Load data from localStorage
            function loadData() {
                const workData = JSON.parse(localStorage.getItem('work_experiences') || '[]');
                workData.forEach(item => {
                    const tmpl = document.getElementById('work-experience-template').content.cloneNode(true);
                    const el = tmpl.querySelector('.work-experience-item');
                    el.querySelector('[name="work_start[]"]').value = item.start;
                    el.querySelector('[name="work_end[]"]').value = item.end;
                    el.querySelector('[name="company_name[]"]').value = item.company;
                    el.querySelector('[name="company_business[]"]').value = item.business;
                    el.querySelector('[name="position[]"]').value = item.position;
                    el.querySelector('[name="reason[]"]').value = item.reason;
                    workList.appendChild(tmpl);
                });

                const eduData = JSON.parse(localStorage.getItem('education_history') || '[]');
                eduData.forEach(item => {
                    const tmpl = document.getElementById('education-template').content.cloneNode(true);
                    const el = tmpl.querySelector('.education-item');
                    el.querySelector('[name="edu_start[]"]').value = item.start;
                    el.querySelector('[name="edu_end[]"]').value = item.end;
                    el.querySelector('[name="edu_name[]"]').value = item.name;
                    el.querySelector('[name="edu_major[]"]').value = item.major;
                    el.querySelector('[name="edu_level[]"]').value = item.level;
                    eduList.appendChild(tmpl);
                });

                const langData = JSON.parse(localStorage.getItem('language_skills') || '[]');
                langData.forEach(item => {
                    const tmpl = document.getElementById('language-template').content.cloneNode(true);
                    const el = tmpl.querySelector('.language-item');
                    el.querySelector('[name="language_name[]"]').value = item.language;
                    el.querySelector('[name="speaking[]"]').value = item.speaking;
                    el.querySelector('[name="reading[]"]').value = item.reading;
                    el.querySelector('[name="writing[]"]').value = item.writing;
                    langList.appendChild(tmpl);
                });

                const spec = JSON.parse(localStorage.getItem('specific_info') || '{}');
                if (spec.pernah) {
                    pernah.value = spec.pernah;
                    if (spec.pernah === 'Ya') {
                        lokasiWrapper.style.display = 'block';
                    }
                }
                document.getElementById('lokasi-bekerja').value = spec.lokasi || '';
                document.getElementById('info-lowongan').value = spec.info || '';
            }

            loadData();

            // Save to localStorage on submit
            document.getElementById('kandidat-form').addEventListener('submit', () => {
                function collect(list, selector, mapper) {
                    const items = [];
                    list.querySelectorAll(selector).forEach(el => items.push(mapper(el)));
                    return items;
                }

                const workData = collect(workList, '.work-experience-item', el => ({
                    start: el.querySelector('[name="work_start[]"]').value,
                    end: el.querySelector('[name="work_end[]"]').value,
                    company: el.querySelector('[name="company_name[]"]').value,
                    business: el.querySelector('[name="company_business[]"]').value,
                    position: el.querySelector('[name="position[]"]').value,
                    reason: el.querySelector('[name="reason[]"]').value,
                }));
                localStorage.setItem('work_experiences', JSON.stringify(workData));
                const workInput = document.getElementById('riwayat_pengalaman_kerja');
                workInput.value = JSON.stringify(workData);
                workInput.dispatchEvent(new Event('input'));

                const eduData = collect(eduList, '.education-item', el => ({
                    start: el.querySelector('[name="edu_start[]"]').value,
                    end: el.querySelector('[name="edu_end[]"]').value,
                    name: el.querySelector('[name="edu_name[]"]').value,
                    major: el.querySelector('[name="edu_major[]"]').value,
                    level: el.querySelector('[name="edu_level[]"]').value,
                }));
                localStorage.setItem('education_history', JSON.stringify(eduData));
                const eduInput = document.getElementById('riwayat_pendidikan');
                eduInput.value = JSON.stringify(eduData);
                eduInput.dispatchEvent(new Event('input'));

                const langData = collect(langList, '.language-item', el => ({
                    language: el.querySelector('[name="language_name[]"]').value,
                    speaking: el.querySelector('[name="speaking[]"]').value,
                    reading: el.querySelector('[name="reading[]"]').value,
                    writing: el.querySelector('[name="writing[]"]').value,
                }));
                localStorage.setItem('language_skills', JSON.stringify(langData));
                const langInput = document.getElementById('kemampuan_bahasa');
                langInput.value = JSON.stringify(langData);
                langInput.dispatchEvent(new Event('input'));

                const specData = {
                    pernah: pernah.value,
                    lokasi: document.getElementById('lokasi-bekerja').value,
                    info: document.getElementById('info-lowongan').value,
                };
                localStorage.setItem('specific_info', JSON.stringify(specData));
                const specInput = document.getElementById('informasi_spesifik');
                specInput.value = JSON.stringify(specData);
                specInput.dispatchEvent(new Event('input'));
            }, true);
        });
    </script>
    @endpush
</div>
