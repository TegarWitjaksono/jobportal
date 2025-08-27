<?php

namespace App\Livewire\BankSoal;

use Livewire\Component;
use App\Models\Soal;
use App\Models\KategoriSoal;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $showModal = false;
    public $soalId;
    public $id_kategori_soal;
    public $soal;
    public $pilihan_1;
    public $pilihan_2;
    public $pilihan_3;
    public $pilihan_4;
    public $jawaban;
    public $status = true;

    public $type_soal = 'text';
    public $type_jawaban = 'text';
    public $tempImage;

    public $types = [
        'text' => 'Text',
        'foto' => 'Gambar',
    ];

    public $oldSoal, $oldPilihan1, $oldPilihan2, $oldPilihan3, $oldPilihan4;


    protected function rules()
    {
        $soalRule = $this->type_soal === 'foto' ? 'required|image|max:1024' : 'required|string';
        $pilihanRule = $this->type_jawaban === 'foto' ? 'required|image|max:1024' : 'required|string';
        
        // Jika dalam mode edit dan tidak ada file baru yang diupload, jangan validasi sebagai image
        if ($this->soalId) {
            if ($this->type_soal === 'foto' && !is_object($this->soal)) {
                $soalRule = 'required';
            }

            for ($i = 1; $i <= 4; $i++) {
                $pilihan = "pilihan_$i";
                if ($this->type_jawaban === 'foto' && !is_object($this->$pilihan)) {
                    $pilihanRule = 'required';
                }
            }
        }
        
        return [
            'id_kategori_soal' => 'required',
            'soal' => $soalRule,
            'pilihan_1' => $pilihanRule,
            'pilihan_2' => $pilihanRule,
            'pilihan_3' => $pilihanRule,
            'pilihan_4' => $pilihanRule,
            'jawaban' => 'required|in:1,2,3,4',
            'type_soal' => 'required',
            'type_jawaban' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        // Ketika tipe soal berubah, reset field soal
        if ($propertyName === 'type_soal') {
            $this->soal = '';
            $this->tempImage = null;
            // $this->emit('typeChanged');
        }

        // Ketika tipe jawaban berubah, reset semua field pilihan
        if ($propertyName === 'type_jawaban') {
            $this->pilihan_1 = '';
            $this->pilihan_2 = '';
            $this->pilihan_3 = '';
            $this->pilihan_4 = '';
        }
        
        $this->validateOnly($propertyName);
    }


    public function render()
    {
        $query = Soal::with('kategori')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    // 1) search inside question text
                    $sub->where('soal', 'like', '%' . $this->search . '%');

                    // 2) search inside choices (text)
                    $sub->orWhere('pilihan_1', 'like', '%' . $this->search . '%')
                        ->orWhere('pilihan_2', 'like', '%' . $this->search . '%')
                        ->orWhere('pilihan_3', 'like', '%' . $this->search . '%')
                        ->orWhere('pilihan_4', 'like', '%' . $this->search . '%');

                    // 3) search inside category name via relationship
                    $sub->orWhereHas('kategori', function ($k) {
                        $k->where('nama_kategori', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest();

        return view('livewire.bank-soal.index', [
            'soals'        => $query->paginate(10),
            'kategoriSoals'=> KategoriSoal::where('status', true)->get(),
            'types'        => $this->types,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $this->soalId = $id;
        $this->id_kategori_soal = $soal->id_kategori_soal;

        $this->oldSoal = $soal->soal;
        $this->oldPilihan1 = $soal->pilihan_1;
        $this->oldPilihan2 = $soal->pilihan_2;
        $this->oldPilihan3 = $soal->pilihan_3;
        $this->oldPilihan4 = $soal->pilihan_4;

        $this->soal = $soal->soal;
        $this->pilihan_1 = $soal->pilihan_1;
        $this->pilihan_2 = $soal->pilihan_2;
        $this->pilihan_3 = $soal->pilihan_3;
        $this->pilihan_4 = $soal->pilihan_4;

        $this->jawaban = $soal->jawaban;
        $this->status = $soal->status;
        $this->type_soal = $soal->type_soal;
        $this->type_jawaban = $soal->type_jawaban;
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'id_kategori_soal' => $this->id_kategori_soal,
            'type_soal' => $this->type_soal,
            'type_jawaban' => $this->type_jawaban,
            'jawaban' => $this->jawaban,
            'status' => $this->status,
        ];

        // Handle soal data
        if ($this->type_soal === 'foto') {
            if (is_object($this->soal) && method_exists($this->soal, 'store')) {
                $data['soal'] = $this->soal->store('soal-images', 'public');
            } elseif ($this->soalId) {
                $data['soal'] = Soal::find($this->soalId)->soal;
            }
        } else {
            $data['soal'] = $this->soal;
        }

        // Handle pilihan data
        for ($i = 1; $i <= 4; $i++) {
            $field = "pilihan_$i";
            if ($this->type_jawaban === 'foto') {
                if (is_object($this->$field) && method_exists($this->$field, 'store')) {
                    $data[$field] = $this->$field->store('jawaban-images', 'public');
                } elseif ($this->soalId) {
                    $data[$field] = Soal::find($this->soalId)->$field;
                }
            } else {
                $data[$field] = $this->$field;
            }
        }

        if ($this->soalId) {
            Soal::find($this->soalId)->update($data);
            session()->flash('message', 'Soal berhasil diperbarui.');
        } else {
            Soal::create($data);
            session()->flash('message', 'Soal berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $soal = Soal::findOrFail($id);

        // Hapus file dari storage sebelum menghapus record dari database
        if ($soal->type_soal === 'foto' && $soal->soal && Storage::disk('public')->exists($soal->soal)) {
            Storage::disk('public')->delete($soal->soal);
        }

        if ($soal->type_jawaban === 'foto') {
            for ($i = 1; $i <= 4; $i++) {
                $pilihan = "pilihan_$i";
                if ($soal->$pilihan && Storage::disk('public')->exists($soal->$pilihan)) {
                    Storage::disk('public')->delete($soal->$pilihan);
                }
            }
        }

        $soal->delete();
        session()->flash('message', 'Soal berhasil dihapus.');
    }

    private function resetForm()
    {
        $this->soalId = null;
        $this->id_kategori_soal = '';
        $this->soal = '';
        $this->pilihan_1 = '';
        $this->pilihan_2 = '';
        $this->pilihan_3 = '';
        $this->pilihan_4 = '';
        $this->jawaban = '';
        $this->status = true;
        $this->type_soal = 'text';
        $this->type_jawaban = 'text';
        $this->oldSoal = null;
        $this->oldPilihan1 = null;
        $this->oldPilihan2 = null;
        $this->oldPilihan3 = null;
        $this->oldPilihan4 = null;
    }
}
