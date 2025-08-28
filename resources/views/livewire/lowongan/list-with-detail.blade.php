<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Available Jobs</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Jobnova</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jobs</li>
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
    <!-- Hero End -->

    <!-- Start -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Filter Form -->
                <div class="col-12 mb-4">
                    <div class="card p-4 rounded shadow">
                        <div class="row align-items-stretch">
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Search</label>
                                    <div class="form-icon position-relative">
                                        <input wire:model="search" type="text" class="form-control ps-5" placeholder="Search job position...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Categories</label>
                                    <select wire:model="selectedCategory" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Location</label>
                                    <select wire:model="selectedLocation" class="form-select">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Job Type</label>
                                    <select wire:model="isRemote" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="1">Remote</option>
                                        <option value="0">On-site</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Salary Range</label>
                                    <select wire:model="salaryRange" class="form-select">
                                        <option value="">All Salary Ranges</option>
                                        @foreach($salaryRanges as $range => $label)
                                            <option value="{{ $range }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 align-self-end">
                                <div class="d-grid">
                                    <button type="button" wire:click="applyFilter" class="btn btn-primary">Apply Filter</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" wire:click="resetFilter" class="btn btn-sm btn-soft-primary">Reset Filter</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail and List -->
                <div class="col-12">
                    <div class="row align-items-stretch">
                        <div class="col-lg-6 mb-4 mb-lg-0 d-flex">
                            @if($selectedJob)
                                <div class="card rounded shadow border-0 h-100 w-100 job-detail">
                                    <div class="card-body">
                                        @if(!empty($selectedJob->foto))
                                            <img src="{{ asset('storage/image/lowongan/' . $selectedJob->foto) }}" alt="{{ $selectedJob->nama_posisi }}" class="cover img-fluid rounded mb-3">
                                        @endif
                                        <h5 class="fw-bold mb-1">{{ $selectedJob->nama_posisi }}</h5>
                                        <p class="text-muted mb-2">{{ $selectedJob->kategoriLowongan->nama_kategori ?? 'Uncategorized' }}</p>
                                        <p class="text-muted mb-2"><i class="mdi mdi-map-marker-outline me-1"></i>{{ $selectedJob->lokasi_penugasan }} - {{ $selectedJob->is_remote ? 'Remote' : 'On-site' }}</p>
                                        <p class="text-muted mb-3"><i class="mdi mdi-cash me-1"></i>{{ $selectedJob->formatted_gaji }}</p>
                                        <div class="mb-4 job-description">{{ strip_tags($selectedJob->deskripsi) }}</div>
                                        <a href="{{ route('login', ['redirect' => url()->current(), 'job_id' => $selectedJob->id]) }}" class="btn btn-primary">Apply Now</a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">Select a job to view details.</div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            @if($lowongans->isEmpty())
                                <div class="alert alert-info">No jobs found matching your criteria.</div>
                            @else
                                @foreach($lowongans as $job)
                                    <div class="job-box card rounded shadow border-0 overflow-hidden mb-3 cursor-pointer" wire:click="selectJob({{ $job->id }})">
                                        <div class="p-3">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    @php
                                                        $thumb = null;
                                                        if (!empty($job->foto)) {
                                                            $thumb = asset('storage/image/lowongan/' . $job->foto);
                                                        } elseif ($job->kategoriLowongan && $job->kategoriLowongan->logo) {
                                                            $thumb = asset('storage/image/logo/kategori-lowongan/' . $job->kategoriLowongan->logo);
                                                        }
                                                    @endphp
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; overflow: hidden;">
                                                        @if($thumb)
                                                            <img src="{{ $thumb }}" alt="{{ $job->nama_posisi }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            <i data-feather="image" class="fea icon-md"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $job->nama_posisi }}</h6>
                                                    <small class="text-muted d-block mb-1"><i class="mdi mdi-map-marker-outline me-1"></i>{{ $job->lokasi_penugasan }}</small>
                                                    @if(!empty($job->deskripsi))
                                                        <div class="text-muted small">{{ \Illuminate\Support\Str::words(strip_tags($job->deskripsi), 16, '...') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $lowongans->withQueryString()->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End -->

    <style>
    .job-detail .cover { width: 100%; max-height: 240px; object-fit: cover; display: block; }
    .job-detail .job-description { white-space: pre-line; word-break: break-word; overflow-wrap: anywhere; }
    .job-list-scroll { scrollbar-gutter: stable; }
    </style>

    @push('scripts')
    <script>
        if(window.feather) feather.replace();
    </script>
    @endpush
</div>
