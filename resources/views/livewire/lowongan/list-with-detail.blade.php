<div>
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Lowongan Pekerjaan Tersedia</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lowongan Pekerjaan Tersedia</li>
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
                <div class="col-12 mb-2">
                    <div class="card p-3 rounded shadow">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4 col-12">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Search</label>
                                    <div class="form-icon position-relative">
                                        <svg class="fea icon-sm icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                        <input wire:model="search" type="text" class="form-control form-control-sm ps-5" placeholder="Search job position...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Categories</label>
                                    <select wire:model="selectedCategory" class="form-select form-select-sm">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Location</label>
                                    <select wire:model="selectedLocation" class="form-select form-select-sm">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Job Type</label>
                                    <select wire:model="isRemote" class="form-select form-select-sm">
                                        <option value="">All Types</option>
                                        <option value="1">Remote</option>
                                        <option value="0">On-site</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Salary Range</label>
                                    <select wire:model="salaryRange" class="form-select form-select-sm">
                                        <option value="">All Salary Ranges</option>
                                        @foreach($salaryRanges as $range => $label)
                                            <option value="{{ $range }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 align-self-end">
                                <div class="d-grid d-md-flex justify-content-md-end gap-2 mb-2">
                                    <button type="button" wire:click="resetFilter" class="btn btn-sm py-2 btn-soft-primary w-100 w-md-auto">
                                        <i class="mdi mdi-reload me-1"></i> Reset Filter
                                    </button>
                                    <button type="button" wire:click="applyFilter" class="btn btn-sm py-2 btn-primary w-100 w-md-auto">
                                        <i class="mdi mdi-tune me-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Detail and List -->
                <div class="col-12">
                    <div class="row align-items-stretch">
                        <div class="col-lg-6 mb-4 mb-lg-0 d-flex flex-column">
                            @if($selectedJob)
                                <div class="card rounded shadow border-0 w-100 job-detail flex-grow-1">
                                    <div class="card-body">
                                        @if(!empty($selectedJob->foto))
                                            <img src="{{ asset('storage/image/lowongan/' . $selectedJob->foto) }}"
                                                 alt="{{ $selectedJob->nama_posisi }}"
                                                 class="img-fluid rounded mb-3"
                                                 style="width:100%; height:240px; object-fit:contain; background:#f8f9fa; display:block;">
                                        @endif
                                        <div class="mb-2">
                                            @if($selectedJob->is_remote)
                                                <span class="badge rounded-pill bg-soft-success text-success d-inline-flex align-items-center">
                                                    <svg class="fea icon-sm me-1 align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
                                                        <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                                                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                                                        <line x1="12" y1="20" x2="12.01" y2="20"></line>
                                                    </svg>
                                                    Remote
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-soft-warning text-warning d-inline-flex align-items-center">
                                                    <svg class="fea icon-sm me-1 align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"></path>
                                                        <circle cx="12" cy="10" r="3"></circle>
                                                    </svg>
                                                    On-site
                                                </span>
                                            @endif
                                        </div>
                                        <h5 class="fw-bold mb-1">{{ $selectedJob->nama_posisi }}</h5>
                                        <p class="text-muted mb-2">{{ $selectedJob->kategoriLowongan->nama_kategori ?? 'Uncategorized' }}</p>
                                        <p class="text-muted mb-2">
                                            <svg class="fea icon-sm me-1 align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            {{ $selectedJob->lokasi_penugasan }}
                                        </p>
                                        <p class="text-muted mb-3"><i class="mdi mdi-cash me-1"></i>{{ $selectedJob->formatted_gaji }}</p>
                                        <div class="mb-4 job-description">{{ strip_tags($selectedJob->deskripsi) }}</div>
                                        <a href="{{ route('login', ['redirect' => url()->current(), 'job_id' => $selectedJob->id]) }}" class="btn btn-sm py-2 btn-primary w-md-auto mt-auto">
                                            <i class="mdi mdi-send-outline me-1"></i> Apply Now
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">Select a job to view details.</div>
                            @endif
                        </div>
                        <div class="col-lg-6 d-flex flex-column">
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
                                                    <div class="bg-soft-light border rounded d-flex align-items-center justify-content-center" style="width:64px;height:64px;overflow:hidden;">
                                                        @if($thumb)
                                                            <img src="{{ $thumb }}" alt="{{ $job->nama_posisi }}" style="width:100%;height:100%;object-fit:cover;">
                                                        @else
                                                            <i data-feather="image" class="fea icon-md"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class="mb-1 text-truncate pe-2">{{ $job->nama_posisi }}</h6>
                                                        @if(!empty($job->tanggal_berakhir))
                                                            <small class="text-muted"><i class="mdi mdi-calendar-clock me-1"></i>{{ \Carbon\Carbon::parse($job->tanggal_berakhir)->format('d M Y') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-1">
                                                        @if(optional($job->kategoriLowongan)->nama_kategori)
                                                            <span class="badge bg-soft-primary text-primary me-1">{{ optional($job->kategoriLowongan)->nama_kategori }}</span>
                                                        @endif
                                                        @isset($job->is_remote)
                                                            <span class="badge {{ $job->is_remote ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }}">{{ $job->is_remote ? 'Remote' : 'On-site' }}</span>
                                                        @endisset
                                                    </div>
                                                    <small class="text-muted d-block mb-1">
                                                        <svg class="fea icon-sm me-1 align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"></path>
                                                            <circle cx="12" cy="10" r="3"></circle>
                                                        </svg>
                                                        {{ $job->lokasi_penugasan }}
                                                        @php($gaji = $job->formatted_gaji ?? ($job->range_gaji ? $job->range_gaji.' Juta' : null))
                                                        @if($gaji)
                                                            <span class="mx-2">•</span><i class="mdi mdi-cash-multiple me-1"></i>{{ $gaji }}
                                                        @endif
                                                    </small>
                                                    @if(!empty($job->deskripsi))
                                                        <div class="text-muted small">{{ \Illuminate\Support\Str::words(strip_tags($job->deskripsi), 16, '...') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-end mt-auto">
                                    {{ $lowongans->withQueryString()->links('pagination.numbers-right') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

@push('scripts')
<script>
    // Ensure feather icons appear after Livewire updates
    (function(){
        function refreshFeather(){
            if (window.feather && typeof window.feather.replace === 'function') {
                window.feather.replace();
            }
        }
        // Initial
        document.addEventListener('DOMContentLoaded', refreshFeather);
        document.addEventListener('livewire:initialized', refreshFeather);
        // After any Livewire DOM patch
        if (window.Livewire && typeof window.Livewire.hook === 'function') {
            window.Livewire.hook('message.processed', refreshFeather);
        } else {
            document.addEventListener('livewire:update', refreshFeather);
            document.addEventListener('livewire:navigated', refreshFeather);
        }
    })();
 </script>
@endpush
