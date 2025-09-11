<?php

namespace App\Livewire\Profile;

use App\Models\Kandidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Dompdf\Dompdf;
use Dompdf\Options;

class ShowProfile extends Component
{
    use WithFileUploads;

    public $kandidat;

    /**
     * Uploaded document placeholders
     */
    public $ktp;
    public $ijazah;
    public $sertifikat;
    public $surat_pengalaman;
    public $skck;
    public $surat_sehat;

    public $showDocumentModal = false;
    public $documents = [];
    public $documentType = null;

    public function mount()
    {
        // Mengambil data user yang sedang login beserta relasi 'kandidat'
        $user = Auth::user()->load('kandidat');
        $this->kandidat = $user->kandidat;

        $this->refreshDocuments();
    }

    public function openDocumentModal($type = null)
    {
        $this->resetUploadFields();
        $this->refreshDocuments();
        $this->documentType = $type;
        $this->showDocumentModal = true;
    }

    public function closeDocumentModal()
    {
        $this->showDocumentModal = false;
        $this->documentType = null;
    }

    protected function resetUploadFields()
    {
        $this->ktp = $this->ijazah = $this->sertifikat = $this->surat_pengalaman = $this->skck = $this->surat_sehat = null;
    }

    public function uploadDocuments()
    {
        $userId = Auth::id();
        $basePath = "documents/{$userId}";
        $fields = $this->documentType
            ? [$this->documentType]
            : [
                'ktp',
                'ijazah',
                'sertifikat',
                'surat_pengalaman',
                'skck',
                'surat_sehat',
            ];

        foreach ($fields as $field) {
            if ($this->$field) {
                $column = $field . '_path';

                // Hapus file lama jika ada
                if ($this->kandidat->$column) {
                    Storage::disk('public')->delete($this->kandidat->$column);
                }

                // Simpan file baru dan update path di database
                $path = $this->$field->storeAs(
                    $basePath,
                    $field . '.' . $this->$field->getClientOriginalExtension(),
                    'public'
                );

                $this->kandidat->$column = $path;
            }
        }

        $this->kandidat->save();

        $this->refreshDocuments();
        $this->closeDocumentModal();
    }

    public function refreshDocuments()
    {
        $this->kandidat->refresh();
        $fields = [
            'ktp',
            'ijazah',
            'sertifikat',
            'surat_pengalaman',
            'skck',
            'surat_sehat',
        ];

        $files = [];
        foreach ($fields as $field) {
            $column = $field . '_path';
            if ($this->kandidat->$column) {
                $files[$field] = $this->kandidat->$column;
            }
        }

        $this->documents = $files;
    }

    public function render()
    {
        // Memberitahu Livewire untuk menggunakan layout utama 'layouts.app'
        return view('livewire.profile.show-profile');
    }

    /**
     * Export kandidat profile data to ATS-friendly CV (PDF)
     */
    public function exportCv()
    {
        if (!$this->kandidat) {
            abort(404);
        }

        $kandidat = $this->kandidat->load('user');

        // Normalize JSON-like fields into arrays
        $workData = $kandidat->riwayat_pengalaman_kerja;
        if (!is_array($workData)) {
            $workData = json_decode($workData ?? '[]', true) ?: [];
        }
        $eduData = $kandidat->riwayat_pendidikan;
        if (!is_array($eduData)) {
            $eduData = json_decode($eduData ?? '[]', true) ?: [];
        }
        $langData = $kandidat->kemampuan_bahasa;
        if (!is_array($langData)) {
            $langData = json_decode($langData ?? '[]', true) ?: [];
        }

        // Decode specific info
        $specData = $kandidat->informasi_spesifik;
        if (!is_array($specData)) {
            $specData = json_decode($specData ?? '[]', true) ?: [];
        }

        // Build supporting document previews as images only (skip PDF)
        $docPaths = [
            'KTP' => $kandidat->ktp_path,
            'Ijazah' => $kandidat->ijazah_path,
            'Sertifikat' => $kandidat->sertifikat_path,
            'Surat Pengalaman Kerja' => $kandidat->surat_pengalaman_path,
            'SKCK' => $kandidat->skck_path,
            'Surat Sehat' => $kandidat->surat_sehat_path,
        ];
        $docImages = [];
        foreach ($docPaths as $label => $relPath) {
            if (!$relPath) continue;
            $fullPath = storage_path('app/public/' . ltrim($relPath, '/'));
            if (!is_file($fullPath)) continue;

            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            // Only embed common image types; skip PDFs entirely
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp','bmp'])) {
                continue;
            }
            $mime = match ($ext) {
                'jpg','jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'bmp' => 'image/bmp',
                default => 'application/octet-stream',
            };
            $data = @file_get_contents($fullPath);
            if ($data !== false) {
                $docImages[$label] = 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        }

        // If neither GD nor Imagick is available for Dompdf, skip embedding images
        $canRenderImages = extension_loaded('gd');
        if (!$canRenderImages) {
            $docImages = [];
        }

        $html = view('livewire.profile.cv-export', [
            'kandidat' => $kandidat,
            'workData' => $workData,
            'eduData' => $eduData,
            'langData' => $langData,
            'specData' => $specData,
            'docImages' => $docImages,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'CV-' . trim(($kandidat->nama_depan . ' ' . $kandidat->nama_belakang)) . '-' . now()->format('Ymd_His') . '.pdf';

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName);
    }
}
