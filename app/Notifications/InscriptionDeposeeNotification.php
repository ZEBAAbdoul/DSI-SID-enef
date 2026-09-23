<?php

namespace App\Notifications;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionDeposeeNotification extends Notification implements ShouldQueue
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
            ->subject('Votre candidature a bien été enregistrée — ' . $this->inscription->numero_dossier)
            ->greeting('Bonjour ' . ($notifiable->name ?? ''))
            ->line("Votre dossier de candidature n° {$this->inscription->numero_dossier} a bien été enregistré.")
            ->line("Formation : {$this->inscription->formation?->titre}")
            ->line('Notre équipe va procéder à la vérification de vos pièces justificatives. Vous serez notifié à chaque étape.')
            ->action('Suivre mon dossier', route('admin.inscription.show', $this->inscription->id))
            ->line('Merci de votre confiance.');
    }
}