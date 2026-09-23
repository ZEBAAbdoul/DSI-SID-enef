<?php

namespace App\Notifications;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionValideeNotification extends Notification implements ShouldQueue
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
            ->subject('Dossier validé — ' . $this->inscription->numero_dossier)
            ->view('emails.notification', [
                'greeting' => 'Félicitations ' . ($notifiable->name ?? ''),
                'lines' => [
                    "Votre dossier de candidature n° {$this->inscription->numero_dossier} a été validé.",
                    'Vous pouvez maintenant procéder au paiement des frais de scolarité.',
                    "Bienvenue à l'ENEF !",
                ],
                'actionText' => 'Voir mon dossier',
                'actionUrl' => url('/enef'),
                'salutation' => "Cordialement, l'équipe ENEF",
            ]);
    }
}