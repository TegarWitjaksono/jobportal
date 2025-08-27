<div>
    @php
        $isRecruiter = strtolower(optional(auth()->user()->officer)->jabatan) === 'recruiter';
    @endphp
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
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Officers') }}</h5>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Home') }}</a></li>
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

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 rounded shadow">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('Officer List') }}</h5>
                            @if(!$isRecruiter)
                                <a href="#" wire:click.prevent="openCreateModal" class="btn btn-primary btn-sm">{{ __('Add New Officer') }}</a>
                            @endif
                        </div>
                        <!-- Filter Section -->
                       <div class="card-body border-bottom">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <div class="search-box">
                                        <input wire:model.defer="search" type="text" class="form-control" placeholder="Search name, NIK..." />
                                        <i class="mdi mdi-magnify search-icon"></i>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <select wire:model.defer="jabatanFilter" class="form-select">
                                        <option value="">{{ __('All Positions') }}</option>
                                        @foreach($positions ?? [] as $position)
                                            <option value="{{ $position }}">{{ $position }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <select wire:model.defer="lokasiFilter" class="form-select">
                                        <option value="">{{ __('All Locations') }}</option>
                                        @foreach($locations ?? [] as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex">
                                    <button wire:click="applyFilters" class="btn btn-primary me-2">
                                        <i class="mdi mdi-filter-outline me-1"></i> {{ __('Apply') }}
                                    </button>
                                    <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                        <i class="mdi mdi-refresh me-1"></i> {{ __('Reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">#</th>
                                            <th wire:click="sortBy('nama_depan')" class="cursor-pointer">
                                                {{ __('Full Name') }}
                                                @if($sortField === 'nama_depan')
                                                    <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('nik')" class="cursor-pointer">
                                                {{ __('NIK') }}
                                                @if($sortField === 'nik')
                                                    <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('jabatan')" class="cursor-pointer">
                                                {{ __('Position') }}
                                                @if($sortField === 'jabatan')
                                                    <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('doh')" class="cursor-pointer">
                                                {{ __('DOH') }}
                                                @if($sortField === 'doh')
                                                    <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('lokasi_penugasan')" class="cursor-pointer">
                                                {{ __('Location') }}
                                                @if($sortField === 'lokasi_penugasan')
                                                    <i class="mdi mdi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </th>
                                            <th class="text-center" style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($officers ?? [] as $index => $officer)
                                            <tr>
                                                <td class="text-center">{{ $officers->firstItem() + $index }}</td>
                                                <td>{{ $officer->nama_depan . ' ' . $officer->nama_belakang }}</td>
                                                <td>{{ $officer->nik }}</td>
                                                <td>{{ $officer->jabatan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($officer->doh)->format('d M Y') }}</td>
                                                <td>{{ $officer->lokasi_penugasan }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="#" wire:click.prevent="openEditModal({{ $officer->id }})" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                        <a href="#" wire:click.prevent="openDeleteModal({{ $officer->id }})" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <div class="py-4">
                                                        <img src="{{ asset('images/empty.svg') }}" alt="No Data" class="img-fluid" style="max-height: 120px;">
                                                        <p class="text-muted my-3">{{ __('No officer records found') }}</p>
                                                        @if(!$isRecruiter)
                                                            <a href="#" wire:click.prevent="openCreateModal" class="btn btn-sm btn-primary">{{ __('Add Your First Officer') }}</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    {{ $officers->links() }}
                                </div>
                            </div>

                            <!-- Include the create modal component -->
                            @if(!$isRecruiter)
                                @livewire('officer.create-modal')
                            @endif
                            @livewire('officer.action-modal')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        /* Improved search box styling */
        .search-box {
            position: relative;
        }

        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-box input {
            padding-right: 30px;
        }

        /* Modal backdrop styles */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Fix for scrollbar jump when modal opens */
        body.modal-open {
            padding-right: 0 !important;
            overflow-y: auto;
        }
    </style>
</div>
