<?php

namespace App\Notifications;

use App\Models\Inscription;
use App\Models\ParametresSite;
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
        // La notification est mise en file d'attente : $parametresSite (partagé aux vues
        // pendant la requête web) n'existe pas dans le worker. On relit donc la valeur ici.
        $contactRh = ParametresSite::first()?->contact_rh;

        $lines = [
            "Votre dossier de candidature n° {$this->inscription->numero_dossier} a été validé. Bienvenue à l'ENEF !",
            $contactRh
                ? 'Pour procéder au paiement des frais de scolarité, veuillez contacter le Service des Ressources Humaines au numéro suivant :'
                : 'Vous pouvez maintenant procéder au paiement des frais de scolarité.',
        ];

        return (new MailMessage)
            ->subject('Dossier validé — ' . $this->inscription->numero_dossier)
            ->view('emails.notification', [
                'greeting' => 'Félicitations ' . ($notifiable->name ?? ''),
                'lines' => $lines,
                'contactLabel' => 'Service des Ressources Humaines',
                'contactPhone' => $contactRh,
                'actionText' => 'Voir mon dossier',
                'actionUrl' => url('/enef'),
                'salutation' => "Cordialement, l'équipe ENEF",
            ]);
    }
}