<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    /**
     * Stream a file stored on the public disk inline so browsers preview PDFs
     * instead of downloading them.
     */
    public function inline(string $encoded)
    {
        // Decode URL-safe base64 (path segment safe)
        $encoded = strtr($encoded, '-_', '+/');
        $pad = strlen($encoded) % 4;
        if ($pad) { $encoded .= str_repeat('=', 4 - $pad); }
        $relative = base64_decode($encoded, true);
        if ($relative === false) {
            abort(404);
        }

        // Normalize potential prefixes like 'storage/' or 'public/'
        $relative = ltrim($relative, '/\\');
        $relative = preg_replace('#^(storage/|public/)#i', '', $relative);

        // Resolve public disk path safely
        $base = storage_path('app/public');
        $full = $base . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative);
        $path = realpath($full);
        if (!$path || strncmp($path, $base, strlen($base)) !== 0 || !is_file($path)) {
            abort(404);
        }

        $mime = File::mimeType($path) ?: 'application/octet-stream';
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf') {
            $mime = 'application/pdf';
        }

        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ];

        return response()->file($path, $headers);
    }
}
