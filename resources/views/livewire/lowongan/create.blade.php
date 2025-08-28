<div>
    <!-- Scripts -->
    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
    // Inisialisasi Cleave.js pada input dengan id 'salary-range'
        var cleave = new Cleave('#salary-range', {
            blocks: [10],
            delimiter: '',
            numericOnly: false
        });

        document.querySelector('#salary-range').addEventListener('input', function(e) {
            let rawValue = e.target.value;
            @this.set('range_gaji', rawValue);
        });
    </script>
    @endpush

    <!-- Main Content -->
    <div class="content-wrapper">
        @vite('resources/js/app.js')
        
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

        <!-- Hero Section -->
        <section class="bg-half-170 d-table w-100" style="background: url({{ asset('images/hero/bg.jpg') }});">
            <div class="bg-overlay bg-gradient-overlay"></div>
            <div class="container">
                <div class="row mt-5 justify-content-center">
                    <div class="col-12">
                        <div class="title-heading text-center">
                            <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Create Job Vacancy') }}</h5>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="position-middle-bottom">
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('Lowongan.Index') }}">{{ __('Lowongan') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Create Job Vacancy') }}</li>
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

        <!-- Form Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="card border-0">
                            <form wire:submit.prevent="save" class="rounded shadow p-4" enctype="multipart/form-data">
                                <div class="row">
                                    <h5 class="mb-3">Job Details:</h5>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Job Title :</label>
                                            <input wire:model.defer="nama_posisi" class="form-control" placeholder="Title">
                                            @error('nama_posisi') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Description :</label>
                                        <div wire:ignore>
                                            <textarea id="description-editor" wire:model.defer="deskripsi" class="form-control"></textarea>
                                        </div>
                                        @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Department:</label>
                                            <input wire:model.defer="departemen" class="form-control" placeholder="Department">
                                            @error('departemen') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Location:</label>
                                            <input wire:model.defer="lokasi_penugasan" class="form-control" placeholder="Location">
                                            @error('lokasi_penugasan') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Remote:</label>
                                            <select wire:model.defer="is_remote" class="form-control form-select">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            @error('is_remote') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Category:</label>
                                            <select wire:model.defer="kategori_lowongan_id" class="form-control form-select">
                                                <option value="">Select Category</option>
                                                @foreach($kategoriLowonganOptions as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                            @error('kategori_lowongan_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Posting Date:</label>
                                            <input type="date" wire:model.defer="tanggal_posting" class="form-control">
                                            @error('tanggal_posting') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">End Date:</label>
                                            <input type="date" wire:model.defer="tanggal_berakhir" class="form-control">
                                            @error('tanggal_berakhir') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Salary Range:</label>
                                            
                                            {{-- Gunakan wire:ignore agar Livewire tidak mengganggu input yang sudah diatur oleh Cleave.js --}}
                                            <div class="input-group" wire:ignore>
                                                <input type="text" 
                                                    id="salary-range" 
                                                    class="form-control" 
                                                    placeholder="e.g. 5-10">
                                                <span class="input-group-text">jt</span>
                                            </div>

                                            @error('range_gaji') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Required Skills:</label>
                                            <input wire:model.defer="kemampuan_yang_dibutuhkan" class="form-control" placeholder="Skills">
                                            @error('kemampuan_yang_dibutuhkan') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Photo:</label>
                                            <input type="file" wire:model="foto" class="form-control" accept="image/*">
                                            @error('foto') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="submit" class="submitBnt btn btn-primary" value="Post Now">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Styles -->
        <style>
            .ck-editor__editable {
                min-height: 200px !important;
                max-height: 400px !important;
            }
            
            .ck-editor__editable:focus {
                border-color: #80bdff !important;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
            }

            .dark .ck.ck-editor__main>.ck-editor__editable {
                background: #2d3748;
                color: #fff;
            }
        </style>

        <!-- Editor Scripts -->
        @push('scripts')
        <script>
            ClassicEditor
                .create(document.querySelector('#description-editor'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    },
                    language: 'en',
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    licenseKey: '',
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('deskripsi', editor.getData());
                    });
                    
                    // Mendengarkan event Livewire untuk mengupdate editor
                    window.livewire.on('contentReset', () => {
                        editor.setData('');
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
        @endpush
    </div>
</div>
