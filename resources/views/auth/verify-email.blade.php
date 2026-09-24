{{-- resources/views/auth/verify-email.blade.php --}}
<x-guest-layout>
    @section('title')
        {{ "Vérification de l'adresse e-mail" }}
    @endsection

    <div class="enef-auth">
        <div class="enef-card">

            @include('auth.partials.enef-aside')

            {{-- ===================== CONTENU ===================== --}}
            <main class="enef-main">

                <header class="enef-heading">
                    <span class="enef-badge-icon" aria-hidden="true">
                        <i class="fas fa-envelope-open-text"></i>
                    </span>
                    <h1>Vérifiez votre adresse e-mail</h1>
                    <p class="enef-lead">
                        Merci pour votre inscription ! Avant de commencer, veuillez confirmer votre adresse
                        e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez rien reçu,
                        nous vous en enverrons un autre avec plaisir.
                    </p>
                </header>

                {{-- Adresse à laquelle le lien a été envoyé --}}
                @auth
                    <div class="enef-chip">
                        <i class="fas fa-at" aria-hidden="true"></i>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                @endauth

                {{-- Confirmation du renvoi --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="enef-alert enef-alert--success" role="status">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        <div>
                            Un nouveau lien de vérification a été envoyé à l'adresse e-mail
                            fournie lors de votre inscription.
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="enef-alert enef-alert--danger" role="alert">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- RENVOYER LE LIEN --}}
                <form method="POST" action="{{ route('verification.send') }}" id="enefResendForm">
                    @csrf

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Renvoyer l'e-mail de vérification</span>
                    </button>
                </form>

                <div class="enef-divider"><span>Ce n'est pas votre compte ?</span></div>

                {{-- DÉCONNEXION --}}
                <form method="POST" action="{{ route('logout') }}" class="enef-links">
                    @csrf

                    <button type="submit" class="enef-link">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Se déconnecter
                    </button>
                </form>

                <p class="enef-security">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    Pensez à vérifier votre dossier de courriers indésirables.
                </p>
            </main>
        </div>
    </div>

    @include('auth.partials.enef-styles')

    <style>
        /* Spécifique à cette page */
        .enef-chip {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            max-width: 100%;
            margin-bottom: 1.1rem;
            padding: .5rem .9rem;
            border: 1px solid #cfe2d1;
            border-radius: 50rem;
            background: #f1f8f2;
            font-size: .86rem;
            font-weight: 600;
            color: #1b5e20;
            word-break: break-all;
        }

        /* Le bouton "Se déconnecter" hérite du style des liens */
        button.enef-link {
            background: transparent;
            cursor: pointer;
            font-family: inherit;
        }
    </style>

    <script>
        (function() {
            // État "chargement" à l'envoi (anti double-clic)
            var form = document.getElementById('enefResendForm');
            var btn = document.getElementById('enefSubmit');

            if (form && btn) {
                var label = btn.querySelector('.enef-btn-label');
                var spinner = btn.querySelector('.enef-spinner');
                var texte = label.textContent;

                form.addEventListener('submit', function() {
                    btn.disabled = true;
                    label.textContent = 'Envoi en cours…';
                    spinner.style.display = 'inline-block';
                });

                // Retour arrière du navigateur : on réactive le bouton
                window.addEventListener('pageshow', function(e) {
                    if (e.persisted) {
                        btn.disabled = false;
                        label.textContent = texte;
                        spinner.style.display = 'none';
                    }
                });
            }
        })();
    </script>
</x-guest-layout>