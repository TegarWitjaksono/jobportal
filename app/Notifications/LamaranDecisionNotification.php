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
    public array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(LamarLowongan $lamaran, string $status, ?string $officerName = null, array $data = [])
    {
        $this->lamaran = $lamaran;
        $this->status = $status;
        $this->officerName = $officerName;
        $this->data = $data;
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
                'schedule' => $this->data['schedule'] ?? null,
            ]);

        // Jika diterima dan ada path lampiran (untuk penawaran online), lampirkan filenya.
        if ($this->status === 'diterima' && !empty($this->data['attachment'])) {
            $mail->attach($this->data['attachment'], [
                'as' => 'offering-letter.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
