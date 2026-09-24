<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Envoie à un nouvel utilisateur ses identifiants de connexion.
 *
 * Volontairement PAS mise en file d'attente (pas de ShouldQueue) : le mot de passe
 * temporaire ne doit pas être écrit en clair dans la table des jobs.
 */
class CompteCreeNotification extends Notification
{
    public function __construct(private string $motDePasse) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre compte ENEF a été créé')
            ->view('emails.notification', [
                'greeting' => 'Bienvenue' . ($notifiable->name ? ' ' . $notifiable->name : '') . ' !',
                'lines' => [
                    "Un compte vient de vous être créé sur la plateforme de l'ENEF. Voici vos identifiants de connexion :",
                ],
                'details' => [
                    'Identifiant (adresse e-mail)' => $notifiable->email,
                    'Mot de passe temporaire' => $this->motDePasse,
                ],
                'actionText' => 'Se connecter',
                'actionUrl' => route('login'),
                'showFallbackLink' => true,
                'salutation' => "Pour votre sécurité, modifiez ce mot de passe dès votre première connexion depuis votre profil, et ne le communiquez à personne. Cordialement, l'équipe ENEF",
            ]);
    }
}