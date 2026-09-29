<?php

namespace App\Providers;

use App\Models\Inscription;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        // Règle de mot de passe appliquée partout où le code utilise Password::defaults()
        Password::defaults(fn() => Password::min(12));

        // ---------- Cloche de notification : inscriptions « en_cours » ----------
        View::composer('components.navbar', function ($view) {
            $user = Auth::user();
            $rolesAutorises = ['super-admin', 'admin', 'dg', 'sg', 'sc', 'se'];
            $afficherCloche = $user && $user->hasAnyRole($rolesAutorises);

            $view->with([
                'afficherCloche' => $afficherCloche,
                'inscriptionsEnCoursCount' => $afficherCloche ? Inscription::statutEnCours()->count() : 0,
                'inscriptionsEnCours' => $afficherCloche
                    ? Inscription::statutEnCours()
                    ->with(['candidat.personne', 'formation'])
                    ->latest('date_soumission')
                    ->limit(5)
                    ->get()
                    : collect(),
            ]);
        });

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
