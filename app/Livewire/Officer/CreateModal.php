<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Repositories\Interfaces\OfficerRepositoryInterface;

class CreateModal extends Component
{
    // Modal state
    public $show = false;
    public $officerData = [];
    public $userData = [];

    // For location selection
    public $selectedLocation = '';
    public $newLocationName = '';

    // Data for dropdowns
    public $positions = [];
    public $locations = [];
    public $supervisors = [];
    protected $officerRepository;

    protected $listeners = ['showModal' => 'showModal'];

    // Validation rules
    protected function rules()
    {
        return [
            'officerData.nama_depan' => 'required|min:2',
            'officerData.nama_belakang' => 'required|min:2',
            'officerData.nik' => 'required|unique:officers,nik',
            'officerData.jabatan' => 'required',
            'officerData.doh' => 'required|date',
            'officerData.area' => 'required|in:1,2,3',
            'officerData.atasan_id' => 'nullable|exists:officers,id',
            'selectedLocation' => 'required_unless:newLocationName,null',
            'newLocationName' => 'required_if:selectedLocation,custom|min:3',
            'userData.email' => 'required|email|unique:users,email',
            'userData.password' => 'required|min:8',
        ];
    }

    public function boot(OfficerRepositoryInterface $officerRepository)
    {
        // Initialize repository
        $this->officerRepository = $officerRepository;

    }


    public function loadDropdownData()
    {
        $this->positions = $this->officerRepository->getUniquePositions();
        $this->locations = $this->officerRepository->getUniqueLocations();
        $this->supervisors = $this->officerRepository->getAllOfficersForSupervisorSelection();
    }

    public function showModal()
    {
        $this->resetInputFields();
        $this->loadDropdownData(); // Refresh dropdown data
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->officerData = [];
        $this->userData = [];
        $this->selectedLocation = '';
        $this->newLocationName = '';
    }

    public function createOfficer()
    {
        // Set the location before validation
        if ($this->selectedLocation === 'custom') {
            $this->officerData['lokasi_penugasan'] = $this->newLocationName;
        } elseif (!empty($this->selectedLocation)) {
            $this->officerData['lokasi_penugasan'] = $this->selectedLocation;
        }
        if (empty($this->officerData['atasan_id'])) {
            $this->officerData['atasan_id'] = null;
        }

        $this->validate();

        try {
            // Use the repository method to create both user and officer
            $this->officerRepository->createOfficerWithUser($this->officerData, $this->userData);

            // Close modal
            $this->closeModal();

            // Use dispatch to send notification data to parent
            $this->dispatch('showNotification', [
                'status' => 'success',
                'message' => __('Officer created successfully!')
            ]);

            // Also emit the officer created event for data refresh
            $this->dispatch('officerCreated');

        } catch (\Exception $e) {
            // Dispatch error notification
            $this->dispatch('showNotification', [
                'status' => 'error',
                'message' => __('Error creating officer: ') . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.officer.create-modal');
    }
}
