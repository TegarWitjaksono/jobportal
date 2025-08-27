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
    <section class="bg-half-170 d-table w-100" style="background: url('images/hero/bg.jpg');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Category Vacancies') }}</h5>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Category Vacancies') }}</li>
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
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 rounded shadow">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('Category Vacancies') }}</h5>
                            <button class="btn btn-primary btn-sm" wire:click="$dispatch('showCreateModal')">{{ __('Add Category') }}</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 60px;">Logo</th>
                                            <th>{{ __('Name Category') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th class="text-center" style="width: 15%;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kategoriLowongans as $kategori)
                                            <tr>
                                                <td class="text-center">
                                                    @if($kategori->logo)
                                                        <img src="{{ asset('storage/image/logo/kategori-lowongan/' . $kategori->logo) }}"
                                                                alt="Logo"
                                                                class="img-fluid rounded"
                                                                style="max-width:40px; max-height:40px;">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $kategori->nama_kategori }}</td>
                                                <td>{{ \Illuminate\Support\Str::words($kategori->deskripsi, 8, '...') }}</td>
                                                <td class="p-3">
                                                    {{-- Tombol Edit --}}
                                                    <button class="btn btn-sm btn-soft-warning me-1" wire:click="openEditModal({{ $kategori->id }})">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>

                                                    {{-- Tombol Hapus --}}
                                                    <button class="btn btn-sm btn-soft-danger" wire:click="openDeleteModal({{ $kategori->id }})">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @livewire('kategori-lowongan.form-modal')
                </div>
            </div>
        </div>
    </section>
</div>
