<?php

namespace App\Notifications;

use App\Models\PieceInscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class PieceVerifieeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PieceInscription $piece)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $inscription = $this->piece->inscription;
        $conforme = $this->piece->statut_verification === 'conforme';

        $lines = [];

        if ($conforme) {
            $lines[] = "La pièce « {$this->piece->type_piece_libelle} » de votre dossier n° {$inscription->numero_dossier} a été validée.";
        } else {
            $lines[] = "La pièce « {$this->piece->type_piece_libelle} » de votre dossier n° {$inscription->numero_dossier} n'a pas été acceptée.";
            if ($this->piece->commentaire) {
                $lines[] = 'Motif : ' . $this->piece->commentaire;
            }
            $lines[] = 'Merci de déposer un nouveau fichier dès que possible.';
        }

        return (new MailMessage)
            ->subject(
                $conforme
                    ? 'Pièce validée — Dossier ' . $inscription->numero_dossier
                    : 'Pièce à corriger — Dossier ' . $inscription->numero_dossier
            )
            ->view('emails.notification', [
                'greeting' => 'Bonjour ' . ($notifiable->name ?? ''),
                'lines' => $lines,
                'actionText' => 'Voir mon dossier',
                'actionUrl' => url('/enef'),                
                            ]);
                    }
}