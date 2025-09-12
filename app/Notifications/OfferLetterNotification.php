<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\LamarLowongan;

class OfferLetterNotification extends Notification
{
    use Queueable;

    public LamarLowongan $lamaran;

    public function __construct(LamarLowongan $lamaran)
    {
        $this->lamaran = $lamaran;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lowongan = optional($this->lamaran->lowongan);
        $candidate = optional(optional($this->lamaran->kandidat)->user)->name ?? 'Kandidat';

        $vars = [
            'candidateName' => $candidate,
            'position' => $lowongan->nama_posisi ?? null,
            'department' => $lowongan->departemen ?? null,
            'location' => $lowongan->lokasi_penugasan ?? null,
            'salary' => $lowongan->formatted_gaji ?? $lowongan->range_gaji ?? null,
            'startDate' => null,
            'dashboardUrl' => route('kandidat.lowongan-dilamar'),
        ];

        return (new MailMessage)
            ->subject('Offering Letter - ' . ($lowongan->nama_posisi ?? 'Posisi'))
            ->view('emails.offer-letter', $vars);
    }
}

