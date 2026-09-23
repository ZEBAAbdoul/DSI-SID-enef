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

    public function __construct(public Inscription $inscription) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $lines = [
            "Votre dossier de candidature n° {$this->inscription->numero_dossier} a été marqué comme incomplet.",
        ];

        if ($this->inscription->motif_rejet) {
            $lines[] = 'Précisions : ' . $this->inscription->motif_rejet;
        }

        $lines[] = 'Merci de compléter votre dossier dès que possible.';

        return (new MailMessage)
            ->subject('Dossier incomplet — ' . $this->inscription->numero_dossier)
            ->view('emails.notification', [
                'greeting' => 'Bonjour ' . ($notifiable->name ?? ''),
                'lines' => $lines,
                'actionText' => 'Compléter mon dossier',
                'actionUrl' => url('/enef'),
                'salutation' => "Cordialement, l'équipe ENEF",
            ]);
    }
}