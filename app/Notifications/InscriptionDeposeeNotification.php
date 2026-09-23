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

    public function __construct(public Inscription $inscription) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre candidature a bien été enregistrée — ' . $this->inscription->numero_dossier)
            ->view('emails.notification', [
                'greeting' => 'Bonjour ' . ($notifiable->name ?? ''),
                'lines' => [
                    "Votre dossier de candidature n° {$this->inscription->numero_dossier} a bien été enregistré.",
                    "Formation : {$this->inscription->formation?->titre}",
                    'Notre équipe va procéder à la vérification de vos pièces justificatives. Vous serez notifié à chaque étape.',
                    'Merci de votre confiance.',
                ],
                'actionText' => 'Suivre mon dossier',
                'actionUrl' => url('/enef'),
                'salutation' => "Cordialement, l'équipe ENEF",
            ]);
    }
}