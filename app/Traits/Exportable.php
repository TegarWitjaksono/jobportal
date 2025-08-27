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
        // Placeholder implementation; integrate PDF library as needed
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $html = view($view, $data)->render();
        $callback = function () use ($html) {
            // This is a placeholder; real PDF generation requires a dedicated library
            echo $html;
        };

        return response()->stream($callback, 200, $headers);
    }
}

