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
                        
                        <form wire:submit.prevent="updateKandidatProfile" class="card-body p-4">
                            @if ($this->kandidat && ($this->kandidat->bmi_score || $this->kandidat->blind_score))
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">
                                            <i class="mdi mdi-file-document-check-outline me-2"></i>Data Hasil Tes
                                        </h6>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ __('Skor BMI') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $this->kandidat->bmi_score }}" readonly>
                                            <span class="input-group-text">{{ $this->kandidat->bmi_category }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ __('Skor Tes Buta Warna') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $this->kandidat->blind_score }}" readonly>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <hr class="my-4">
                            @endif
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
                                    <input id="negara" type="text" class="form-control @error('state.negara') is-invalid @enderror" 
                                        wire:model.defer="state.negara" placeholder="Masukkan negara" value="Indonesia">
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

                                <div class="col-md-6 mb-3">
                                    <label for="pendidikan" class="form-label">{{ __('Pendidikan Terakhir') }} <span class="text-danger">*</span></label>
                                    <select id="pendidikan" wire:model.defer="state.pendidikan" class="form-select @error('state.pendidikan') is-invalid @enderror">
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
                                    </select>
                                    @error('state.pendidikan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="pengalaman_kerja" class="form-label">{{ __('Pengalaman Kerja (Opsional)') }}</label>
                                    <textarea id="pengalaman_kerja" class="form-control @error('state.pengalaman_kerja') is-invalid @enderror" 
                                        wire:model.defer="state.pengalaman_kerja" rows="4" 
                                        placeholder="Deskripsikan pengalaman kerja Anda, termasuk posisi, perusahaan, dan periode kerja"></textarea>
                                    <small class="text-muted">Contoh: Software Developer di PT ABC (2020-2023), Web Designer di PT XYZ (2018-2020)</small>
                                    @error('state.pengalaman_kerja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="kemampuan_bahasa" class="form-label">{{ __('Kemampuan Bahasa (Opsional)') }}</label>
                                    <textarea id="kemampuan_bahasa" class="form-control @error('state.kemampuan_bahasa') is-invalid @enderror" 
                                        wire:model.defer="state.kemampuan_bahasa" rows="2" 
                                        placeholder="Sebutkan bahasa yang Anda kuasai dan tingkat kemahirannya"></textarea>
                                    <small class="text-muted">Contoh: Indonesia (Native), Inggris (Menengah), Mandarin (Pemula)</small>
                                    @error('state.kemampuan_bahasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
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

    {{-- Auto-hide alerts after 5 seconds --}}
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
        });
    </script>
    @endpush
</div>
