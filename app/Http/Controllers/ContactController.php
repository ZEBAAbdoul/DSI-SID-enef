<?php

namespace App\Http\Controllers;

use App\Models\ParametresSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /** Délai minimum (secondes) entre l'affichage du formulaire et sa soumission. */
    private const MIN_SUBMIT_DELAY = 5;

    /**
     * Affiche la page de contact avec le formulaire.
     */
    public function index(Request $request)
    {
        $param_site = cache()->remember('site.parametres.contact', now()->addMinutes(10), function () {
            return ParametresSite::first();
        });

        $math = $this->issueMathChallenge($request);

        return view('contact.index', compact('param_site', 'math'));
    }

    /**
     * Valide le formulaire (anti-spam gratuit) puis envoie le message sur le mail de l'ENEF.
     */
    public function send(Request $request)
    {
        // Anti-spam invisible : si le honeypot est rempli ou si le formulaire
        // a été soumis trop vite, on ignore la requête sans se faire remarquer.
        if ($this->looksLikeSpam($request)) {
            return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
        }

        $expected = $this->expectedMathAnswer($request);

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'sujet' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:5000'],
            'math_answer' => ['required', 'string', 'max:3', function ($attribute, $value, $fail) use ($expected) {
                if ($expected === null || ! hash_equals($expected, trim((string) $value))) {
                    $fail('Réponse incorrecte. Veuillez résoudre le petit calcul.');
                }
            }],
        ]);

        $param_site = ParametresSite::first();
        $destinataire = $param_site?->email_contact ?: 'infos@enef.gov.bf';

        $body = "Nom : {$validated['nom']}\n"
            . "Email : {$validated['email']}\n"
            . ($validated['telephone'] ? "Téléphone : {$validated['telephone']}\n" : '')
            . "Sujet : {$validated['sujet']}\n"
            . "------------------------------\n"
            . $validated['message'];

        try {
            Mail::raw($body, function ($message) use ($destinataire, $validated) {
                $message->to($destinataire)
                    ->replyTo($validated['email'], $validated['nom'])
                    ->subject('Contact ENEF — ' . $validated['sujet']);
            });
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->with('error', "Votre message n'a pas pu être envoyé. Veuillez réessayer plus tard.");
        }

        $request->session()->forget('contact_math');

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }

    /**
     * Crée (ou conserve) un petit calcul à résoudre, rangé chiffré en session.
     *
     * @return array{a: int, b: int}
     */
    private function issueMathChallenge(Request $request): array
    {
        if ($encrypted = $request->session()->get('contact_math')) {
            try {
                $parts = explode('|', (string) decrypt($encrypted));
                if (count($parts) === 3) {
                    return ['a' => (int) $parts[0], 'b' => (int) $parts[1]];
                }
            } catch (\Throwable) {
                // session invalide → on régénère
            }
        }

        $math = ['a' => random_int(2, 9), 'b' => random_int(2, 9)];
        $request->session()->put('contact_math', encrypt(implode('|', [$math['a'], $math['b'], $math['a'] + $math['b']])));

        return $math;
    }

    /**
     * Récupère la réponse attendue depuis la session, ou null si absente.
     */
    private function expectedMathAnswer(Request $request): ?string
    {
        $encrypted = $request->session()->get('contact_math');

        if (! $encrypted) {
            return null;
        }

        try {
            $parts = explode('|', (string) decrypt($encrypted));
        } catch (\Throwable) {
            return null;
        }

        return count($parts) === 3 ? (string) end($parts) : null;
    }

    /**
     * Détecte le spam : honeypot rempli ou soumission trop rapide.
     */
    private function looksLikeSpam(Request $request): bool
    {
        if ($request->filled('website')) {
            return true;
        }

        $renderedAt = (int) $request->input('honeypot_time', 0);

        return $renderedAt <= 0 || ((int) $request->server('REQUEST_TIME', time())) - $renderedAt < self::MIN_SUBMIT_DELAY;
    }
}