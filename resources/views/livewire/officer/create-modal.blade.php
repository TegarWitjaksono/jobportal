<div>
    <!-- Create Officer Modal -->
    <div class="modal fade @if($show) show @endif" id="createOfficerModal" tabindex="-1" role="dialog"
         aria-labelledby="createOfficerModalTitle" @if($show) style="display: block; background-color: rgba(0, 0, 0, 0.5);" @else style="display: none;" @endif>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createOfficerModalTitle">
                        <i class="mdi mdi-account-plus me-1"></i> {{ __('Tambah Officer Baru') }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <!-- Errors Notifications -->
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- End Errors Notifications -->
                <form wire:submit.prevent="createOfficer">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nama Depan') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('officerData.nama_depan') is-invalid @enderror"
                                    wire:model.defer="officerData.nama_depan" placeholder="Nama Depan">
                                @error('officerData.nama_depan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nama Belakang') }}</label>
                                <input type="text" class="form-control @error('officerData.nama_belakang') is-invalid @enderror"
                                    wire:model.defer="officerData.nama_belakang" placeholder="Nama Belakang">
                                @error('officerData.nama_belakang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('NIK') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('officerData.nik') is-invalid @enderror"
                                    wire:model.defer="officerData.nik" placeholder="NIK">
                                @error('officerData.nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Jabatan') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('officerData.jabatan') is-invalid @enderror"
                                        wire:model.defer="officerData.jabatan">
                                    <option value="">{{ __('Pilih Jabatan') }}</option>
                                    @foreach($positions ?? [] as $position)
                                        <option value="{{ $position }}">{{ $position }}</option>
                                    @endforeach
                                </select>
                                @error('officerData.jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('officerData.doh') is-invalid @enderror"
                                    wire:model.defer="officerData.doh">
                                @error('officerData.doh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Lokasi Penugasan') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('selectedLocation') is-invalid @enderror @error('officerData.lokasi_penugasan') is-invalid @enderror"
                                        wire:model.defer="selectedLocation">
                                        <option value="">{{ __('Select Location') }}</option>
                                        @foreach($locations ?? [] as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                        <option value="custom">{{ __('Add New Location...') }}</option>
                                    </select>
                                    @error('selectedLocation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @error('officerData.lokasi_penugasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Custom Location Input (shows only when "Add New Location" is selected) -->
                            <div class="col-md-6" x-data="{}" x-show="$wire.selectedLocation === 'custom'">
                                <label class="form-label">{{ __('New Location Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('newLocationName') is-invalid @enderror"
                                    wire:model.defer="newLocationName" placeholder="{{ __('Enter new location name') }}">
                                @error('newLocationName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Area') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('officerData.area') is-invalid @enderror"
                                        wire:model.defer="officerData.area">
                                    <option value="">{{ __('Select Area') }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                @error('officerData.area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                {{-- NOTE: GET OFFICER FOR ATASAN USING OFFICER ID --}}
                                <label class="form-label">{{ __('Supervisor') }}</label>
                                <select class="form-select @error('officerData.atasan_id') is-invalid @enderror"
                                        wire:model.defer="officerData.atasan_id">
                                    <option value="">{{ __('No Supervisor (Top Level)') }}</option>
                                    @foreach($supervisors ?? [] as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->nama_depan . ' ' . $supervisor->nama_belakang }}</option>
                                    @endforeach
                                </select>
                                @error('officerData.atasan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <hr class="my-3">
                            <h6 class="fw-bold">{{ __('Informasi Akun Pengguna') }}</h6>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('userData.email') is-invalid @enderror"
                                    wire:model.defer="userData.email" placeholder="{{ __('Email') }}">
                                @error('userData.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('userData.password') is-invalid @enderror"
                                    wire:model.defer="userData.password" placeholder="{{ __('Password') }}">
                                @error('userData.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">{{ __('Batal') }}</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire:target="createOfficer" class="spinner-border spinner-border-sm me-1"></span>
                            {{ __('Simpan Officer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


