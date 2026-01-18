<?php
namespace App\Livewire\Officer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Repositories\Interfaces\OfficerRepositoryInterface;

class ActionModal extends Component
{
    public $show = false;
    public $officerId;
    public $officerData = [];
    protected $officerRepository;
    public $mode = 'edit'; // 'edit' atau 'deactivate'
    public $supervisors = [];

    protected $listeners = [
        'editOfficer' => 'openEditModal',
        'deleteOfficer' => 'openDeleteModal'
    ];

    public function boot(OfficerRepositoryInterface $officerRepository)
    {
        $this->officerRepository = $officerRepository;
    }

    public function openEditModal($id)
    {
        $this->mode = 'edit';
        $this->officerId = $id;
        $officer = $this->officerRepository->findOfficer($id);
        $this->officerData = $officer->toArray();
        $this->supervisors = $this->officerRepository->getAllOfficersForSupervisorSelection();
        $this->show = true;
    }

    public function updateOfficer()
    {
        $this->validate([
            'officerData.nama_depan' => 'required',
            'officerData.nama_belakang' => 'nullable',
            'officerData.nik' => 'required',
            'officerData.atasan_id' => 'nullable|exists:officers,id',
            'officerData.jabatan' => 'required',
            'officerData.doh' => 'required|date',
            'officerData.lokasi_penugasan' => 'required',
        ]);

        // Pastikan supervisor null jika kosong
        if (empty($this->officerData['atasan_id'])) {
            $this->officerData['atasan_id'] = null;
        }

        $this->officerData['user_update'] = Auth::id();
        $this->officerData['updated_at'] = Carbon::now();

        $this->officerRepository->updateOfficer($this->officerId, $this->officerData);
        $this->show = false;
        $this->dispatch('officerUpdated');
        $this->dispatch('showNotification', [
            'status' => 'success',
            'message' => __('Officer updated successfully!')
        ]);
    }

    public function openDeleteModal($id)
    {
        $this->mode = 'deactivate';
        $this->officerId = $id;
        $this->show = true;
    }

    public function softDeleteOfficer()
    {
        try {
            $result = $this->officerRepository->updateOfficer($this->officerId, [
                'is_active' => 0,
                'user_update' => Auth::id(),
                'updated_at' => Carbon::now(),
            ]);

            if ($result) {
                $this->dispatch('officerUpdated');
                $this->dispatch('showNotification', [
                    'status' => 'success',
                    'message' => __('Officer deactivated successfully!')
                ]);
            } else {
                $this->dispatch('showNotification', [
                    'status' => 'error',
                    'message' => __('Failed to deactivate officer!')
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('showNotification', [
                'status' => 'error',
                'message' => __('Error: ') . $e->getMessage()
            ]);
        }
        $this->show = false;
        $this->dispatch('officerUpdated');
        $this->dispatch('showNotification', [
            'status' => 'success',
            'message' => __('Officer deactivated successfully!')
        ]);
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.officer.action-modal', [
            'supervisors' => $this->supervisors,
        ]);
    }
}

