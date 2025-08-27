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
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
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
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari soal atau kategori..." wire:model.live.debounce.300ms="search">
                        <button class="btn btn-primary" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button wire:click="create" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Soal
                    </button>
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
                                @forelse($soals as $soal)
                                <tr class="align-middle">
                                    <td class="p-3">
                                        @if($soal->type_soal == 'foto')
                                            <img src="{{ Storage::url($soal->soal) }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="Soal">
                                        @else
                                            <span title="{{ $soal->soal }}">{{ Str::limit($soal->soal, 50) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3">{{ $soal->kategori->nama_kategori }}</td>

                                    {{-- Render Choices --}}
                                    @for($i = 1; $i <= 4; $i++)
                                        @php $pilihan = "pilihan_$i"; @endphp
                                        <td class="p-3 text-center">
                                            @if($soal->type_jawaban == 'foto')
                                                <img src="{{ Storage::url($soal->$pilihan) }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;" alt="Pilihan {{ $i }}">
                                            @else
                                                <span title="{{ $soal->$pilihan }}">{{ Str::limit($soal->$pilihan, 15) }}</span>
                                            @endif
                                        </td>
                                    @endfor

                                    <td class="p-3 fw-bold">
                                        Pilihan {{ $soal->jawaban }}
                                    </td>
                                    <td class="p-3">
                                        <span class="badge {{ $soal->status ? 'bg-soft-success' : 'bg-soft-danger' }} text-capitalize">
                                            {{ $soal->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $soal->id_soal }})" class="btn btn-sm btn-soft-warning me-2"><i class="mdi mdi-pencil"></i></button>
                                            <button wire:click="delete({{ $soal->id_soal }})" wire:confirm="Anda yakin ingin menghapus soal ini?" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-trash-can-outline"></i></button>
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
                        <div class="mt-4">
                            {{ $soals->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    {{-- Content End --}}

    {{-- Modal Form --}}
    @if($showModal)
    <div class="modal fade show" tabindex="-1" style="display: block;" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-light p-4">
                    <h5 class="modal-title">{{ $soalId ? 'Edit Soal' : 'Tambah Soal Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <form wire:submit.prevent="save" x-data="{ type_soal: @entangle('type_soal').live, type_jawaban: @entangle('type_jawaban').live }">
                    <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                        <div class="row g-4">
                            {{-- Left Column: Basic Info & Question --}}
                            <div class="col-lg-6 border-end pe-lg-4">
                                <h6 class="text-muted">Informasi Dasar</h6>
                                <hr class="mt-1 mb-3">
                                
                                <div class="mb-3">
                                    <label class="form-label">Kategori Soal <span class="text-danger">*</span></label>
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
                                        <label class="form-label">Tipe Soal</label>
                                        <select wire:model.live="type_soal" class="form-select">
                                            @foreach($types as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Tipe Jawaban</label>
                                        <select wire:model.live="type_jawaban" class="form-select">
                                            @foreach($types as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <h6 class="text-muted mt-3">Isi Soal</h6>
                                <hr class="mt-1 mb-3">
                                <div class="mb-3">
                                    <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                                    <div x-show="type_soal == 'foto'">
                                        <input type="file" wire:model="soal" class="form-control" accept="image/*">
                                        @if ($soal && method_exists($soal, 'temporaryUrl'))
                                            <img src="{{ $soal->temporaryUrl() }}" class="img-fluid rounded my-2" style="max-height: 150px; border: 1px solid #ddd; padding: 3px;">
                                        @elseif(is_string($oldSoal) && $soal == $oldSoal)
                                            <img src="{{ Storage::url($oldSoal) }}" class="img-fluid rounded my-2" style="max-height: 150px; border: 1px solid #ddd; padding: 3px;">
                                        @endif
                                    </div>
                                    <div x-show="type_soal != 'foto'">
                                        <textarea wire:model="soal" class="form-control" rows="4" placeholder="Tulis pertanyaan soal di sini..."></textarea>
                                    </div>
                                    @error('soal') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Right Column: Answer Choices --}}
                            <div class="col-lg-6 ps-lg-4">
                                <h6 class="text-muted">Pilihan Jawaban</h6>
                                <hr class="mt-1 mb-3">
                                <div class="row g-3">
                                @for($i = 1; $i <= 4; $i++)
                                    @php $pilihan = "pilihan_$i"; $oldPilihan = "oldPilihan$i"; @endphp
                                    <div class="col-sm-6">
                                        <label class="form-label">Pilihan {{ $i }} <span class="text-danger">*</span></label>
                                        <div x-show="type_jawaban == 'foto'">
                                            <input type="file" wire:model="{{ $pilihan }}" class="form-control" accept="image/*">
                                            @if ($$pilihan && method_exists($$pilihan, 'temporaryUrl'))
                                                <img src="{{ $$pilihan->temporaryUrl() }}" class="img-fluid rounded my-2" style="max-height: 80px; border: 1px solid #ddd; padding: 3px;">
                                            @elseif(is_string($$oldPilihan) && $$pilihan == $$oldPilihan)
                                                <img src="{{ Storage::url($$oldPilihan) }}" class="img-fluid rounded my-2" style="max-height: 80px; border: 1px solid #ddd; padding: 3px;">
                                            @endif
                                        </div>
                                        <div x-show="type_jawaban != 'foto'">
                                            <input type="text" wire:model="{{ $pilihan }}" class="form-control" placeholder="Teks jawaban {{ $i }}">
                                        </div>
                                        @error($pilihan) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                @endfor
                                </div>
                                
                                <h6 class="text-muted mt-4">Kunci Jawaban & Status</h6>
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
                    <div class="modal-footer p-3 bg-light">
                        <button type="button" class="btn btn-soft-secondary" wire:click="$set('showModal', false)">Batal</button>
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
</div>