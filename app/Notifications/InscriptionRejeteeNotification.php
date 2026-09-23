<?php

namespace App\Notifications;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionRejeteeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Inscription $inscription)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dossier non retenu — ' . $this->inscription->numero_dossier)
            ->greeting('Bonjour ' . ($notifiable->name ?? ''))
            ->line("Nous vous informons que votre dossier de candidature n° {$this->inscription->numero_dossier} n'a pas été retenu.")
            ->when($this->inscription->motif_rejet, fn ($mail) => $mail->line('Motif : ' . $this->inscription->motif_rejet))
            ->line('Nous vous remercions de l\'intérêt porté à l\'ENEF.');
    }
}