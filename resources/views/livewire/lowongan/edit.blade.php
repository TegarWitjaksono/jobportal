<div>
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">{{ __('Edit Job Vacancy') }}</h5>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('Lowongan.Index') }}">{{ __('Lowongan') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
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
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="card border-0">
                        {{-- Form diubah untuk memanggil metode 'update' --}}
                        <form wire:submit.prevent="update" class="rounded shadow p-4" enctype="multipart/form-data">
                            <div class="row">
                                <h5 class="mb-3">Edit Job Details:</h5>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Job Title :</label>
                                        <input wire:model.defer="nama_posisi" class="form-control" placeholder="Title">
                                        @error('nama_posisi') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Input Deskripsi dengan CKEditor --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Description :</label>
                                    <div wire:ignore>
                                        <textarea id="description-editor" class="form-control">{!! $deskripsi !!}</textarea>
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

                                {{-- Input Gaji dengan Cleave.js --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Salary Range:</label>
                                        <div class="input-group" wire:ignore>
                                            <input type="text" 
                                                id="salary-range" 
                                                class="form-control" 
                                                placeholder="e.g. 5000000"
                                                value="{{ $range_gaji }}"> {{-- Menampilkan data awal --}}
                                            <span class="input-group-text">IDR</span>
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

                                {{-- Input Foto dengan Tampilan Gambar Saat Ini --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Photo:</label>
                                        <input type="file" wire:model="foto" class="form-control" accept="image/*">
                                        @if($oldFoto)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/image/lowongan/' . $oldFoto) }}" alt="Current Photo" style="max-width:80px;max-height:80px; border-radius: 5px;">
                                                <small class="text-muted d-block">Current Photo</small>
                                            </div>
                                        @endif
                                        @error('foto') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{-- Tombol diubah menjadi 'Update Job' --}}
                                    <input type="submit" class="submitBnt btn btn-primary" value="Update Job">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    {{-- CDN untuk CKEditor dan Cleave.js --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    {{-- Inisialisasi CKEditor untuk form edit --}}
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
                }
            })
            .then(editor => {
                // Set data awal dari server (lebih andal daripada @this.get di v3)
                editor.setData(@json($deskripsi ?? ''));

                // Sinkronisasi data saat pengguna selesai mengedit (event 'blur')
                editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                    if (!isFocused) {
                        @this.set('deskripsi', editor.getData());
                    }
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    
    {{-- Inisialisasi Cleave.js untuk format gaji --}}
    <script>
        document.addEventListener('livewire:initialized', function () {
            var cleave = new Cleave('#salary-range', {
                numericOnly: true,
                blocks: [10],
            });

            // Kirim data ke Livewire saat input berubah
            document.querySelector('#salary-range').addEventListener('input', function(e) {
                @this.set('range_gaji', e.target.value);
            });
        });
    </script>
@endpush
