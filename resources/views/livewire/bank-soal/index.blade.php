<div>
    {{-- Notification Area (Toast) --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1051;">
        @if (session()->has('message'))
            <div class="toast show align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="mdi mdi-check-circle-outline me-2"></i>
                        {{ session('message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- Hero Section --}}
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Bank Soal</h5>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bank Soal</li>
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
    {{-- Hero End --}}

    {{-- Content Start --}}
    <section class="section">
        <div class="container">
            <!-- Filter dan Pencarian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Cari soal atau kategori..." wire:model.live.debounce.300ms="search">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex gap-2">
                        <button wire:click="exportPdf"
                                class="btn btn-soft-secondary btn-sm d-inline-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Export PDF" aria-label="Export PDF">
                            <i class="mdi mdi-file-pdf-box me-1"></i> Export PDF
                        </button>
                        <button wire:click="create"
                                class="btn btn-soft-primary btn-sm d-inline-flex align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Tambah Soal" aria-label="Tambah Soal">
                            <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Soal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pengaturan CBT -->
            <div class="row mb-4">
                <div class="col-12">
                    <form wire:submit.prevent="saveCbtSettings" class="card border-0 shadow-sm">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-end gap-3">
                            <div>
                                <div class="fw-semibold mb-1">Pengaturan CBT</div>
                                <div class="text-muted small">Atur jumlah soal acak dan durasi tes.</div>
                            </div>
                            <div class="ms-md-auto"></div>
                            <div class="d-flex gap-2 flex-wrap">
                                <div>
                                    <label class="form-label small mb-1">Jumlah Soal</label>
                                    <input type="number" min="1" max="200" class="form-control form-control-sm" wire:model.defer="cbt_max_questions" placeholder="25">
                                </div>
                                <div>
                                    <label class="form-label small mb-1">Durasi (menit)</label>
                                    <input type="number" min="1" max="240" class="form-control form-control-sm" wire:model.defer="cbt_test_duration" placeholder="30">
                                </div>
                                <div class="align-self-end pb-1">
                                    <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="saveCbtSettings"><i class="mdi mdi-content-save me-1"></i>Simpan</span>
                                        <span wire:loading wire:target="saveCbtSettings"><span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Soal -->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shadow rounded">
                        <table class="table table-center bg-white mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3" style="min-width: 250px;">Soal</th>
                                    <th class="border-bottom p-3">Kategori</th>
                                    <th class="border-bottom p-3 text-center" colspan="4">Pilihan Jawaban</th>
                                    <th class="border-bottom p-3">Jawaban</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($soals as $soalItem)
                                <tr class="align-middle" wire:key="soal-{{ $soalItem->id_soal }}">
                                    <td class="p-3">
                                        @if($soalItem->type_soal == 'foto')
                                            <img src="{{ Storage::url($soalItem->soal) }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: contain;" alt="Soal">
                                        @else
                                            <span title="{{ $soalItem->soal }}">{{ Str::limit($soalItem->soal, 50) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3">{{ $soalItem->kategori->nama_kategori }}</td>

                                    {{-- Render Choices --}}
                                    @for($i = 1; $i <= 4; $i++)
                                        @php $pilihan = "pilihan_$i"; @endphp
                                        <td class="p-3 text-center">
                                            @if($soalItem->type_jawaban == 'foto')
                                                <img src="{{ Storage::url($soalItem->$pilihan) }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: contain;" alt="Pilihan {{ $i }}">
                                            @else
                                                <span title="{{ $soalItem->$pilihan }}">{{ Str::limit($soalItem->$pilihan, 15) }}</span>
                                            @endif
                                        </td>
                                    @endfor

                                    <td class="p-3 fw-bold">
                                        Pilihan {{ $soalItem->jawaban }}
                                    </td>
                                    <td class="p-3">
                                        <span class="badge {{ $soalItem->status ? 'bg-soft-success' : 'bg-soft-danger' }} text-capitalize">
                                            {{ $soalItem->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $soalItem->id_soal }})" class="btn btn-sm btn-soft-warning me-2"><i class="mdi mdi-pencil"></i></button>
                                            <button wire:click="delete({{ $soalItem->id_soal }})" wire:confirm="Anda yakin ingin menghapus soal ini?" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-trash-can-outline"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center p-5">
                                        <div class="text-muted">
                                            <i class="mdi mdi-information-outline fs-3 d-block"></i>
                                            Data tidak ditemukan. Coba kata kunci lain atau buat soal baru.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($soals->hasPages())
                        <div class="mt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-2" wire:loading.class="pe-none opacity-50" wire:target="gotoPage,nextPage,previousPage">
                            <div class="text-muted small">
                                Showing {{ $soals->firstItem() }} to {{ $soals->lastItem() }} of {{ $soals->total() }} results
                            </div>
                            <div class="ms-md-auto">
                                {{ $soals->onEachSide(1)->links("livewire::bootstrap") }}
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </section>

    {{-- Modal Form --}}
    @if($showModal)
    <div class="modal fade show" tabindex="-1" style="display: block;" wire:ignore.self wire:key="bank-soal-modal-{{ $soalId ?: 'create' }}">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-soft-primary text-primary p-4 border-0 rounded-top-3">
                    <h5 class="modal-title d-flex align-items-center mb-0">
                        <i class="mdi mdi-file-document-edit-outline me-2"></i>
                        {{ $soalId ? 'Edit Soal' : 'Tambah Soal Baru' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="cancel"></button>
                </div>
                <form wire:submit.prevent="save" x-data="{ type_soal: @entangle('type_soal').live, type_jawaban: @entangle('type_jawaban').live }">
                    <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                        <div class="row g-4">
                            {{-- Left Column: Basic Info & Question --}}
                            <div class="col-lg-6 border-end pe-lg-4">
                                <h6 class="text-muted d-flex align-items-center">
                                    <i class="mdi mdi-information-outline me-2"></i> Informasi Dasar
                                </h6>
                                <hr class="mt-1 mb-3">
                                
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center"><i class="mdi mdi-shape-outline me-2 text-primary"></i> Kategori Soal <span class="text-danger ms-1">*</span></label>
                                    <select wire:model="id_kategori_soal" class="form-select @error('id_kategori_soal') is-invalid @enderror">
                                        <option value="">Pilih Kategori...</option>
                                        @foreach($kategoriSoals as $kategori)
                                            <option value="{{ $kategori->id_kategori_soal }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori_soal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label d-flex align-items-center"><i class="mdi mdi-view-grid-plus-outline me-2 text-primary"></i> Tipe Soal</label>
                                        <select wire:model.live="type_soal" class="form-select">
                                            @foreach($types as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="small text-muted mt-1">Pilih “Foto” jika pertanyaan berupa gambar.</div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label d-flex align-items-center"><i class="mdi mdi-format-list-bulleted-square me-2 text-primary"></i> Tipe Jawaban</label>
                                        <select wire:model.live="type_jawaban" class="form-select">
                                            @foreach($types as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="small text-muted mt-1">Pilih “Foto” jika pilihan jawaban berupa gambar.</div>
                                    </div>
                                </div>

                                <h6 class="text-muted mt-3 d-flex align-items-center">
                                    <i class="mdi mdi-comment-text-outline me-2"></i> Isi Soal
                                </h6>
                                <hr class="mt-1 mb-3">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center"><i class="mdi mdi-help-circle-outline me-2 text-primary"></i> Pertanyaan <span class="text-danger ms-1">*</span></label>
                                    <div x-show="type_soal == 'foto'" x-transition.opacity>
                                        <input type="file" wire:model="soal" class="form-control" accept="image/*">
                                        <div class="small text-muted mt-1" wire:loading wire:target="soal">
                                            <i class="mdi mdi-loading mdi-spin me-1"></i> Mengunggah gambar...
                                        </div>
                                        {{-- Image Preview Area --}}
                                        <div class="bg-soft-light rounded border p-2 my-2 shadow-sm text-center" style="min-height: 170px; display: flex; align-items: center; justify-content: center;">
                                            @php $questionMedia = $this->soal; @endphp
                                            @if ($questionMedia instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                                <img src="{{ $questionMedia->temporaryUrl() }}" class="img-fluid rounded zoomable-image" style="max-height: 150px; cursor: zoom-in;">
                                            @elseif($soalId && is_string($questionMedia) && $questionMedia !== '')
                                                <img src="{{ Storage::url($questionMedia) }}" class="img-fluid rounded zoomable-image" style="max-height: 150px; cursor: zoom-in;">
                                            @elseif(!empty($this->oldSoal))
                                                <img src="{{ Storage::url($this->oldSoal) }}" class="img-fluid rounded zoomable-image" style="max-height: 150px; cursor: zoom-in;">
                                            @else
                                                <div class="text-muted">
                                                    <i class="mdi mdi-image-outline fs-3"></i>
                                                    <div>Pratinjau Gambar</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="small text-muted">Format: JPG/PNG • Disarankan rasio 1:1 atau 4:3</div>
                                    </div>
                                    <div x-show="type_soal != 'foto'" x-transition.opacity>
                                        <textarea wire:model="soal" class="form-control" rows="4" placeholder="Tulis pertanyaan soal di sini..."></textarea>
                                    </div>
                                    @error('soal') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Right Column: Answer Choices --}}
                            <div class="col-lg-6 ps-lg-4">
                                <h6 class="text-muted d-flex align-items-center">
                                    <i class="mdi mdi-format-list-bulleted me-2"></i> Pilihan Jawaban
                                </h6>
                                <hr class="mt-1 mb-3">
                                <div class="row g-3">
                                @for($i = 1; $i <= 4; $i++)
                                    @php $pilihan = "pilihan_$i"; @endphp
                                    <div class="col-sm-6">
                                        <label class="form-label">Pilihan {{ $i }} <span class="text-danger">*</span></label>
                                        <div x-show="type_jawaban == 'foto'" x-transition.opacity>
                                            <input type="file" wire:model="{{ $pilihan }}" class="form-control" accept="image/*">
                                            <div class="small text-muted mt-1" wire:loading wire:target="{{ $pilihan }}">
                                                <i class="mdi mdi-loading mdi-spin me-1"></i> Mengunggah gambar...
                                            </div>
                                            {{-- Image Preview Area for Answers --}}
                                            <div class="bg-soft-light rounded border p-2 my-2 shadow-sm text-center" style="min-height: 100px; display: flex; align-items: center; justify-content: center;">
                                                @php
                                                    $optionMedia = $this->$pilihan;
                                                    $oldOptionKey = 'oldPilihan' . $i;
                                                    $optionOldMedia = $this->$oldOptionKey ?? null;
                                                @endphp
                                                @if ($optionMedia instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                                    <img src="{{ $optionMedia->temporaryUrl() }}" class="img-fluid rounded zoomable-image" style="max-height: 80px; cursor: zoom-in;">
                                                @elseif($soalId && is_string($optionMedia) && $optionMedia !== '')
                                                    <img src="{{ Storage::url($optionMedia) }}" class="img-fluid rounded zoomable-image" style="max-height: 80px; cursor: zoom-in;">
                                                @elseif(!empty($optionOldMedia))
                                                    <img src="{{ Storage::url($optionOldMedia) }}" class="img-fluid rounded zoomable-image" style="max-height: 80px; cursor: zoom-in;">
                                                @else
                                                    <div class="text-muted small">
                                                        <i class="mdi mdi-image-outline fs-5"></i>
                                                        <div>Pratinjau</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div x-show="type_jawaban != 'foto'" x-transition.opacity>
                                            <input type="text" wire:model="{{ $pilihan }}" class="form-control" placeholder="Teks jawaban {{ $i }}">
                                        </div>
                                        @error($pilihan) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                @endfor
                                </div>
                                
                                <h6 class="text-muted mt-4 d-flex align-items-center">
                                    <i class="mdi mdi-key-outline me-2"></i> Kunci Jawaban & Status
                                </h6>
                                <hr class="mt-1 mb-3">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                        <select wire:model="jawaban" class="form-select @error('jawaban') is-invalid @enderror">
                                            <option value="">Pilih Jawaban...</option>
                                            <option value="1">Pilihan 1</option>
                                            <option value="2">Pilihan 2</option>
                                            <option value="3">Pilihan 3</option>
                                            <option value="4">Pilihan 4</option>
                                        </select>
                                        @error('jawaban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-4 d-flex align-items-end justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" wire:model="status" class="form-check-input" id="statusCheck" role="switch">
                                            <label class="form-check-label" for="statusCheck">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-3 bg-light border-0 rounded-bottom-3">
                        <button type="button" class="btn btn-soft-secondary" wire:click="cancel">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal-backdrop fade show"></div>

    @endif

    <style>
  /* Scoped pagination polish */
  .pagination-clean .pagination { gap: .25rem; flex-wrap: wrap; }
  .pagination-clean .page-link {
    border-radius: .5rem;
    min-width: 38px; height: 38px;
    display: inline-flex; align-items: center; justify-content: center;
    color: #6c757d; background: #fff; border: 1px solid rgba(0,0,0,.08);
    transition: .15s ease-in-out;
  }
  .pagination-clean .page-item.active .page-link {
    background-color: var(--bs-primary); border-color: var(--bs-primary); color: #fff;
    box-shadow: 0 0 0 .15rem rgba(var(--bs-primary-rgb, 13,110,253), .15);
  }
  .pagination-clean .page-link:hover { background: #f8f9fa; color: #495057; }
  .pagination-clean .page-item.disabled .page-link { color: #adb5bd; background: #fff; }

    /* Lightbox styles */
    .lightbox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        z-index: 1070; /* Higher than modal (1055) and its backdrop (1050) */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
        -webkit-backdrop-filter: blur(5px);
        backdrop-filter: blur(5px);
    }
    .lightbox-overlay img {
        max-width: 90vw;
        max-height: 90vh;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        cursor: default;
    }
    </style>

    @push('scripts')
    <script>
        const setupLightbox = () => {
            document.querySelectorAll('.zoomable-image').forEach(img => {
                if (img.dataset.lightboxAttached) return;
                img.dataset.lightboxAttached = true;

                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const overlay = document.createElement('div');
                    overlay.className = 'lightbox-overlay';
                    overlay.innerHTML = `<img src="${this.src}" alt="Image Preview">`;
                    document.body.appendChild(overlay);
                    overlay.addEventListener('click', () => overlay.remove());
                });
            });
        };

        document.addEventListener('livewire:navigated', () => {
            setupLightbox();
            Livewire.hook('morph.updated', () => setupLightbox());
        });
    </script>
    @endpush
</div>









