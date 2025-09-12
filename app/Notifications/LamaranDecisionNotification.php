<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\LamarLowongan;
use Dompdf\Dompdf;
use Dompdf\Options;

class LamaranDecisionNotification extends Notification
{
    use Queueable;

    public LamarLowongan $lamaran;
    public string $status;
    public ?string $officerName;

    /**
     * Create a new notification instance.
     */
    public function __construct(LamarLowongan $lamaran, string $status, ?string $officerName = null)
    {
        $this->lamaran = $lamaran;
        $this->status = $status;
        $this->officerName = $officerName;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $lowongan = optional($this->lamaran->lowongan)->nama_posisi ?: 'Posisi yang dilamar';
        $candidate = optional(optional($this->lamaran->kandidat)->user)->name ?: 'Kandidat';
        $statusLabel = $this->status === 'diterima' ? 'DITERIMA' : ($this->status === 'ditolak' ? 'DITOLAK' : strtoupper($this->status));
        $subject = "Keputusan Lamaran: {$lowongan} - {$statusLabel}";

        $dashboardUrl = route('kandidat.lowongan-dilamar');

        $mail = (new MailMessage)
            ->subject($subject)
            ->view('emails.lamaran-decision', [
                'subject' => $subject,
                'candidate' => $candidate,
                'lowongan' => $lowongan,
                'status' => $this->status,
                'statusLabel' => $statusLabel,
                'officerName' => $this->officerName,
                'dashboardUrl' => $dashboardUrl,
            ]);

        // If accepted, attach PDF offer letter
        if ($this->status === 'diterima') {
            $lowonganModel = optional($this->lamaran->lowongan);

            $vars = [
                'candidateName' => $candidate,
                'position' => $lowonganModel->nama_posisi ?? null,
                'department' => $lowonganModel->departemen ?? null,
                'location' => $lowonganModel->lokasi_penugasan ?? null,
                'salary' => $lowonganModel->formatted_gaji ?? $lowonganModel->range_gaji ?? null,
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

            $pdf = $dompdf->output();
            $fileName = 'offering-letter-' . now()->format('Ymd_His') . '.pdf';
            $mail->attachData($pdf, $fileName, ['mime' => 'application/pdf']);
        }

        return $mail;
    }
}
