<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Exportable
{
    public function downloadCsv(string $filename, array $headings, Collection $rows)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($headings, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headings);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadPdf(string $filename, string $view, array $data = [])
    {
        $html = view($view, $data)->render();

        // Ensure the rendered HTML is valid UTF-8 to prevent "Malformed UTF-8" errors
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download($filename);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response($html, 200, $headers);
    }
}

