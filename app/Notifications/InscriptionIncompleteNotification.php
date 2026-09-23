<?php

namespace App\Notifications;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionIncompleteNotification extends Notification implements ShouldQueue
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
            ->subject('Dossier incomplet — ' . $this->inscription->numero_dossier)
            ->greeting('Bonjour ' . ($notifiable->name ?? ''))
            ->line("Votre dossier de candidature n° {$this->inscription->numero_dossier} a été marqué comme incomplet.")
            ->when($this->inscription->motif_rejet, fn ($mail) => $mail->line('Précisions : ' . $this->inscription->motif_rejet))
            ->line('Merci de compléter votre dossier dès que possible.')
            ->action('Compléter mon dossier', route('admin.inscription.show', $this->inscription->id));
    }
}