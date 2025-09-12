<?php

namespace App\Http\Controllers;

use App\Models\LamarLowongan;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class OfferLetterController extends Controller
{
    public function download($lamaranId)
    {
        $user = Auth::user();

        $lamaran = LamarLowongan::with(['kandidat.user', 'lowongan'])
            ->findOrFail($lamaranId);

        // Only owner candidate may download
        if (!$lamaran->kandidat || !$lamaran->kandidat->user || $lamaran->kandidat->user->id !== $user->id) {
            abort(403, 'Tidak diizinkan');
        }

        // Ensure status accepted exists in progress
        $accepted = $lamaran->progressRekrutmen()
            ->where('status', 'diterima')
            ->exists();
        if (!$accepted) {
            abort(403, 'Offering letter belum tersedia.');
        }

        $lowongan = optional($lamaran->lowongan);
        $vars = [
            'candidateName' => optional($lamaran->kandidat->user)->name,
            'position' => $lowongan->nama_posisi ?? '-',
            'department' => $lowongan->departemen ?? null,
            'location' => $lowongan->lokasi_penugasan ?? null,
            'salary' => $lowongan->formatted_gaji ?? $lowongan->range_gaji ?? null,
            'issuedDate' => now(),
        ];

        $html = view('pdf.offer-letter', $vars)->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'offering-letter-' . now()->format('Ymd_His') . '.pdf';
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $fileName, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}

