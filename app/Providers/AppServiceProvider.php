<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        // ---------- E-mail « Réinitialisation du mot de passe » ----------
        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $minutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe')
                ->view('emails.notification', [
                    'greeting' => 'Bonjour' . ($notifiable->name ? ' ' . $notifiable->name : '') . ',',
                    'lines' => [
                        'Vous recevez cet e-mail car une demande de réinitialisation du mot de passe a été effectuée pour votre compte.',
                        "Ce lien de réinitialisation expirera dans {$minutes} minutes.",
                        "Si vous n'êtes pas à l'origine de cette demande, aucune action n'est requise : votre mot de passe reste inchangé.",
                    ],
                    'actionText' => 'Réinitialiser mon mot de passe',
                    'actionUrl' => $url,
                    'showFallbackLink' => true,
                    'salutation' => "Cordialement, l'équipe ENEF",
                ]);
        });

        // ---------- E-mail « Vérification de l'adresse e-mail » ----------
        VerifyEmail::toMailUsing(function ($notifiable, string $verificationUrl) {
            return (new MailMessage)
                ->subject('Vérification de votre adresse e-mail')
                ->view('emails.notification', [
                    'greeting' => 'Bienvenue' . ($notifiable->name ? ' ' . $notifiable->name : '') . ' !',
                    'lines' => [
                        'Merci pour votre inscription. Veuillez confirmer votre adresse e-mail en cliquant sur le bouton ci-dessous.',
                        "Si vous n'avez pas créé de compte, aucune action n'est requise.",
                    ],
                    'actionText' => 'Vérifier mon adresse e-mail',
                    'actionUrl' => $verificationUrl,
                    'showFallbackLink' => true,
                    'salutation' => "Cordialement, l'équipe ENEF",
                ]);
        });
    }
}