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
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Kategori Soal</h5>
                    </div>
                </div>
            </div>
            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kategori Soal</li>
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
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Cari kategori..." wire:model.live.debounce.300ms="search">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button wire:click="create"
                            class="btn btn-soft-primary btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Tambah Kategori" aria-label="Tambah Kategori">
                        <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shadow rounded">
                        <table class="table table-center bg-white mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3">Nama Kategori</th>
                                    <th class="border-bottom p-3">Deskripsi</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                <tr class="align-middle">
                                    <td class="p-3">{{ $kategori->nama_kategori }}</td>
                                    <td class="p-3">{{ Str::limit($kategori->deskripsi, 70) }}</td>
                                    <td class="p-3">
                                        <span class="badge {{ $kategori->status ? 'bg-soft-success' : 'bg-soft-danger' }} text-capitalize">
                                            {{ $kategori->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $kategori->id_kategori_soal }})" class="btn btn-sm btn-soft-warning me-2"><i class="mdi mdi-pencil"></i></button>
                                            <button wire:click="delete({{ $kategori->id_kategori_soal }})" wire:confirm="Yakin ingin menghapus kategori ini?" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-trash-can-outline"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <div class="text-muted">
                                            <i class="mdi mdi-information-outline fs-3 d-block"></i>
                                            Data tidak ditemukan. Tambah kategori baru.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($kategoris->hasPages())
                        <div class="mt-4">
                            {{ $kategoris->links('pagination::bootstrap-5') }}
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-soft-primary text-primary p-4 border-0 rounded-top-3">
                    <h5 class="modal-title d-flex align-items-center mb-0">
                        <i class="mdi mdi-shape-outline me-2"></i>
                        {{ $kategoriId ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center"><i class="mdi mdi-label-outline me-2 text-primary"></i> Nama Kategori <span class="text-danger ms-1">*</span></label>
                            <input type="text" wire:model="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Masukkan nama kategori">
                            @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center"><i class="mdi mdi-text-long me-2 text-primary"></i> Deskripsi</label>
                            <textarea wire:model="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Opsional: deskripsi singkat kategori"></textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="small text-muted mt-1">Deskripsi membantu membedakan kategori serupa.</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="status" id="statusCheck">
                            <label class="form-check-label" for="statusCheck">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer p-4 bg-light border-0 rounded-bottom-3">
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
