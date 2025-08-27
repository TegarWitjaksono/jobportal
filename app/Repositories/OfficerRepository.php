<?php

namespace App\Repositories;

use App\Models\Officer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\OfficerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OfficerRepository implements OfficerRepositoryInterface
{
    protected $model;

    public function __construct(Officer $officer)
    {
        $this->model = $officer;
    }

    public function getAllOfficers(array $filters = [], string $sortField = 'nama_depan', string $sortDirection = 'asc', int $perPage = 10)
    {
        $query = $this->model->query();
        $query->where('is_active', true);
        // Apply search filters if provided
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nama_depan', 'like', '%' . $search . '%')
                ->orWhere('nama_belakang', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('jabatan', 'like', '%' . $search . '%')
                ->orWhere('lokasi_penugasan', 'like', '%' . $search . '%');
            });
        }

        // Filter by position
        if (isset($filters['jabatan']) && !empty($filters['jabatan'])) {
            $query->where('jabatan', $filters['jabatan']);
        }

        // Filter by location
        if (isset($filters['lokasi']) && !empty($filters['lokasi'])) {
            $query->where('lokasi_penugasan', $filters['lokasi']);
        }

        // Handle sorting for combined fields
        if ($sortField === 'nama_lengkap') {
            // Use nama_depan as the primary sort field when nama_lengkap is requested
            $query->orderBy('nama_depan', $sortDirection)
                ->orderBy('nama_belakang', $sortDirection);
        } else {
            // Use the requested sort field
            $query->orderBy($sortField, $sortDirection);
        }

        // Return paginated results
        return $query->paginate($perPage);
    }

    public function findOfficer($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createOfficer(array $data)
    {
        return $this->model->create($data);
    }

    public function updateOfficer($id, array $data)
    {
        $officer = $this->findOfficer($id);
        $officer->update($data);
        return $officer;
    }

    public function deleteOfficer($id)
    {
        $officer = $this->findOfficer($id);
        return $officer->delete();
    }

    public function getUniquePositions()
    {
        $positions = $this->model->select('jabatan')->distinct()->pluck('jabatan')->toArray();
        if (!in_array('Recruiter', $positions)) {
            $positions[] = 'Recruiter';
        }
        sort($positions);
        return collect($positions);
    }

    public function getUniqueLocations()
    {
        return $this->model->select('lokasi_penugasan')->distinct()->orderBy('lokasi_penugasan')->pluck('lokasi_penugasan');
    }

    /**
     * Create both a user and an officer record within a transaction
     *
     * @param array $officerData The officer data
     * @param array $userData The user account data
     * @return Officer The created officer
     * @throws \Exception If creation fails
     */
    public function createOfficerWithUser(array $officerData, array $userData)
    {
        return DB::transaction(function () use ($officerData, $userData) {
            $user = User::create([
                'name' => $officerData['nama_depan'] . ' ' . $officerData['nama_belakang'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => 'officer'
            ]);

            // Create the officer with user_id
            $officerData['user_id'] = $user->id;
            $officerData['user_create'] = Auth::id();

            // Use Existing method to create the officer
            return $this->createOfficer($officerData);
        });
    }

    public function getAllOfficersForSupervisorSelection()
    {
        return $this->model->select('user_id', 'nama_depan', 'nama_belakang', 'jabatan')
            ->orderBy('nama_depan')
            ->get();
    }

    public function getOfficerByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }
}
