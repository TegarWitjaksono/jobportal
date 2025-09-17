<div>
    <!-- Hero Section -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Profil Officer') }}</h5>
                        <p class="text-white-50 para-desc mx-auto mb-0">{{ __('Kelola informasi akun dan keamanan kata sandi Anda di satu tempat.') }}</p>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">{{ __('Beranda') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Profil Officer') }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <!-- Shape Divider -->
    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    <!-- Content -->
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="mdi mdi-check-circle-outline me-1"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-4 align-items-stretch">
                        <!-- Profile Summary -->
                        <div class="col-lg-5">
                            <div class="card border-0 shadow h-100">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $photo ? $photo->temporaryUrl() : $officer->profile_photo_url }}" alt="{{ $officer->full_name }}" class="rounded-circle object-cover border" style="width: 96px; height: 96px;">
                                            <span class="position-absolute top-50 start-50 translate-middle d-none" wire:loading.class.remove="d-none" wire:target="photo">
                                                <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                                            </span>
                                        </div>
                                        <h5 class="fw-semibold mb-0 mt-3">{{ $officer->full_name }}</h5>
                                        <span class="badge {{ $user->role_badge_class }} px-3 py-1 mt-2">{{ $user->role_badge_label }}</span>
                                    </div>

                                    <form wire:submit.prevent="saveProfilePhoto" class="mb-4">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <label class="btn btn-outline-primary mb-0" for="officer-photo">
                                                <i class="mdi mdi-camera me-1"></i>{{ __('Pilih Foto Baru') }}
                                                <input type="file" id="officer-photo" class="d-none" wire:model.live="photo" accept="image/*">
                                            </label>
                                            @if($officer && $officer->profile_photo_path)
                                                <button type="button" class="btn btn-outline-danger" wire:click="removeProfilePhoto" wire:loading.attr="disabled" wire:target="removeProfilePhoto">
                                                    <i class="mdi mdi-trash-can-outline me-1"></i>{{ __('Hapus Foto') }}
                                                </button>
                                            @endif
                                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveProfilePhoto, photo">
                                                <i class="mdi mdi-content-save me-1"></i>{{ __('Simpan Foto') }}
                                            </button>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">{{ __('Format yang didukung: JPG, JPEG, PNG. Maksimal 2 MB.') }}</p>
                                        @error('photo')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </form>

                                    <div class="mb-3">
                                        <p class="text-muted small mb-1">{{ __('Email') }}</p>
                                        <p class="fw-medium text-dark mb-0">{{ $user->email }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-muted small mb-1">{{ __('Jabatan') }}</p>
                                        <p class="fw-medium text-dark mb-0">{{ optional($officer)->jabatan ?? __('Tidak tersedia') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-muted small mb-1">{{ __('Tanggal Bergabung') }}</p>
                                        <p class="fw-medium text-dark mb-0">
                                            @if(optional($officer)->doh)
                                                {{ optional(optional($officer)->doh)->translatedFormat('d F Y') }}
                                            @else
                                                {{ __('Tidak tersedia') }}
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-muted small mb-1">{{ __('Lokasi Penugasan') }}</p>
                                        <p class="fw-medium text-dark mb-0">{{ optional($officer)->lokasi_penugasan ?? __('Tidak tersedia') }}</p>
                                    </div>

                                    <div class="mb-0">
                                        <p class="text-muted small mb-1">{{ __('Atasan Langsung') }}</p>
                                        <p class="fw-medium text-dark mb-0">{{ optional(optional($officer)->atasan)->full_name ?? __('Tidak tersedia') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div class="col-lg-7">
                            <div class="card border-0 shadow h-100">
                                <div class="card-header bg-primary text-white border-0 py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar-sm flex-shrink-0 bg-soft-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center me-3">
                                            <i class="mdi mdi-lock-reset"></i>
                                        </span>
                                        <div>
                                            <h6 class="mb-0">{{ __('Keamanan Akun') }}</h6>
                                            <small class="text-white-50">{{ __('Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <form wire:submit.prevent="updatePassword" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">{{ __('Kata Sandi Saat Ini') }} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="mdi mdi-lock"></i></span>
                                                <input type="password" id="current_password" class="form-control @error('passwordForm.current_password') is-invalid @enderror" wire:model.defer="passwordForm.current_password" placeholder="********" autocomplete="current-password">
                                                @error('passwordForm.current_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">{{ __('Kata Sandi Baru') }} <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="mdi mdi-lock-outline"></i></span>
                                                    <input type="password" id="password" class="form-control @error('passwordForm.password') is-invalid @enderror" wire:model.defer="passwordForm.password" placeholder="********" autocomplete="new-password">
                                                </div>
                                                @error('passwordForm.password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Kata Sandi') }} <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="mdi mdi-lock-check"></i></span>
                                                    <input type="password" id="password_confirmation" class="form-control" wire:model.defer="passwordForm.password_confirmation" placeholder="********" autocomplete="new-password">
                                                </div>
                                                @error('passwordForm.password_confirmation')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="alert bg-soft-warning text-warning border-0 mt-4" role="alert">
                                            <div class="d-flex">
                                                <i class="mdi mdi-shield-alert-outline me-2 fs-5"></i>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ __('Tips Keamanan') }}</h6>
                                                    <p class="mb-0 small">{{ __('Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol. Jangan gunakan kata sandi yang sama dengan akun lain.') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="reset" class="btn btn-outline-secondary" wire:click="$set('passwordForm', ['current_password' => '', 'password' => '', 'password_confirmation' => ''])">
                                                <i class="mdi mdi-refresh me-1"></i>{{ __('Atur Ulang') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-content-save me-1"></i>{{ __('Perbarui Kata Sandi') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
