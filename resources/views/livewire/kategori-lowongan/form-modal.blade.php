{{-- filepath: resources/views/livewire/kategori-lowongan/form-modal.blade.php --}}
<div class="modal fade @if($show) show @endif" tabindex="-1" style="@if($show) display:block; @endif">
    <div class="modal-dialog">
        <div class="modal-content">
            @if($mode === 'create' || $mode === 'edit')
            <form wire:submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $mode === 'create' ? __('Tambah Kategori') : __('Edit Kategori') }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model.defer="nama_kategori" class="form-control mb-2" placeholder="{{ __('Nama Kategori') }}">
                    <textarea wire:model.defer="deskripsi" class="form-control mb-2" placeholder="{{ __('Deskripsi') }}"></textarea>
                    <input type="file" wire:model="logo" class="form-control mb-2" accept="image/*">
                    @if($oldLogo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/image/logo/kategori-lowongan/' . $oldLogo) }}" alt="Logo" style="max-width:60px;max-height:60px;">
                            <small class="text-muted">{{ __('Current Logo') }}</small>
                        </div>
                    @endif
                    @error('logo') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ $mode === 'create' ? __('Save') : __('Update') }}</button>
                </div>
            </form>
            @elseif($mode === 'delete')
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Deactivate Category') }}</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger">{{ __('Are you sure you want to deactivate this category?') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" wire:click="softDelete">{{ __('Deactivate') }}</button>
            </div>
            @endif
        </div>
    </div>
</div>
