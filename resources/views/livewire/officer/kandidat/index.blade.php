<div>
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Manajemen Kandidat</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('officers.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manajemen Kandidat</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <!-- Filter dan Pencarian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kandidat..." wire:model.live="search">
                        <button class="btn btn-primary" type="button">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 text-md-end">
                    <button class="btn btn-secondary" wire:click="exportPdf">
                        <i class="mdi mdi-file-pdf-box"></i> Export to PDF
                    </button>
                </div>
            </div>

            <!-- Tabel Kandidat -->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shadow rounded">
                        <table class="table table-center bg-white mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-3">Nama Lengkap</th>
                                    <th class="border-bottom p-3">No. Telepon</th>
                                    <th class="border-bottom p-3">Email</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kandidats as $kandidat)
                                <tr>
                                    <td class="p-3">{{ $kandidat->getFullNameAttribute() }}</td>
                                    <td class="p-3">{{ $kandidat->no_telpon }}</td>
                                    <td class="p-3">{{ $kandidat->user->email }}</td>
                                    <td class="p-3">
                                        <span class="badge bg-soft-success">Aktif</span>
                                    </td>
                                    <td class="p-3">
                                        <button class="btn btn-sm btn-soft-primary me-1"
                                            wire:click="showDetail({{ $kandidat->id }})">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-soft-warning me-1" wire:click="edit({{ $kandidat->id }})">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-soft-danger"
                                            wire:click="confirmDelete({{ $kandidat->id }})">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-3">Tidak ada data kandidat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $kandidats->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

            <!-- Modal Detail Kandidat -->
            @if($showDetailModal)
            <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Kandidat</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->getFullNameAttribute() }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->no_telpon }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. KTP</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->no_ktp }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Alamat</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->getFormattedAddressAttribute() }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat, Tanggal Lahir</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ $selectedKandidat->tempat_lahir }},
                                        {{ $selectedKandidat->tanggal_lahir?->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->jenis_kelamin }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Perkawinan</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->status_perkawinan }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agama</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->agama }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->pendidikan }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Pengalaman Kerja</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->pengalaman_kerja }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Kemampuan</label>
                                    <p class="mb-0 fw-semibold">{{ $selectedKandidat->kemampuan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Modal Edit Kandidat -->
            @if($showEditModal)
            <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kandidat</h5>
                            <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Depan</label>
                                <input type="text" class="form-control" wire:model.defer="editingKandidat.nama_depan">
                                  @error('editingKandidat.nama_depan')
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Belakang</label>
                                <input type="text" class="form-control" wire:model.defer="editingKandidat.nama_belakang">
                                @error('editingKandidat.nama_belakang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" wire:model.defer="editingKandidat.no_telpon">
                                @error('editingKandidat.no_telpon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeEditModal">Batal</button>
                            <button type="button" class="btn btn-primary" wire:click="updateKandidat">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('confirm-delete', (event) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data kandidat akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.deleteKandidat();
                    }
                });
            });
        });
    </script>
@endpush

