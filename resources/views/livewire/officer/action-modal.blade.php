<div>
    <div class="modal fade @if($show) show @endif" tabindex="-1" style="@if($show) display:block; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                @if($mode === 'edit')
                <form wire:submit.prevent="updateOfficer">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Edit Officer') }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" wire:model.defer="officerData.nik" class="form-control mb-2" placeholder="NIK">
                        <input type="text" wire:model.defer="officerData.nama_depan" class="form-control mb-2" placeholder="Nama Depan">
                        <input type="text" wire:model.defer="officerData.nama_belakang" class="form-control mb-2" placeholder="Nama Belakang">
                        <select wire:model.defer="officerData.atasan_id" class="form-control mb-2">
                            <option value="">{{ __('No Supervisor (Top Level)') }}</option>
                            @foreach($supervisors ?? [] as $supervisor)
                                <option value="{{ $supervisor->id }}">{{ $supervisor->nama_depan . ' ' . $supervisor->nama_belakang }}</option>
                            @endforeach
                        </select>
                        <input type="text" wire:model.defer="officerData.jabatan" class="form-control mb-2" placeholder="Position">
                        <input type="date" wire:model.defer="officerData.doh" class="form-control mb-2" placeholder="Date of Hire">
                        <input type="text" wire:model.defer="officerData.lokasi_penugasan" class="form-control mb-2" placeholder="Location">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
                @elseif($mode === 'deactivate')
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Deactivate Officer') }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to deactivate this officer?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="softDeleteOfficer">Deactivate</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
