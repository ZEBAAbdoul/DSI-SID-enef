{{-- resources/views/auth/forgot-password.blade.php --}}
<x-guest-layout>
    @section('title')
        {{ 'Mot de passe oublié' }}
    @endsection

    <br>
    <br>
    <br>
    <div class="enef-auth">
        <div class="enef-card">

            @include('auth.partials.enef-aside')

            {{-- ===================== FORMULAIRE ===================== --}}
            <main class="enef-main">

                <header class="enef-heading">
                    <span class="enef-badge-icon" aria-hidden="true">
                        <i class="fas fa-key"></i>
                    </span>
                    <h1>Mot de passe oublié ?</h1>
                    <p class="enef-lead">
                        Aucun problème. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien
                        de réinitialisation qui vous permettra de choisir un nouveau mot de passe.
                    </p>
                </header>

                {{-- Confirmation d'envoi --}}
                @if (session('status'))
                    <div class="enef-alert enef-alert--success" role="status">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                {{-- Erreurs (adresse inconnue, trop de tentatives…) --}}
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

                <form action="{{ route('password.email') }}" method="POST" id="enefForgotForm">
                    @csrf

                    <div class="enef-group">
                        <label for="email" class="enef-label">Adresse e-mail</label>
                        <div class="enef-field">
                            <i class="fas fa-envelope enef-icon" aria-hidden="true"></i>
                            <input id="email" name="email" type="email"
                                class="enef-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="exemple@domaine.bf" required autofocus
                                autocomplete="email" @error('email') aria-invalid="true" @enderror>
                        </div>
                    </div>

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Envoyer le lien de réinitialisation</span>
                    </button>
                </form>

                <div class="enef-divider"><span>Vous vous souvenez de votre mot de passe ?</span></div>

                <div class="enef-links">
                    <a href="{{ route('login') }}" class="enef-link enef-link--primary">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à la connexion
                    </a>
                </div>

                <p class="enef-security">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    Le lien reçu est valable pour une durée limitée. Pensez à vérifier vos courriers indésirables.
                </p>
            </main>
        </div>
    </div>

    @include('auth.partials.enef-styles')

    <script>
        (function() {
            // État "chargement" à l'envoi (anti double-clic)
            var form = document.getElementById('enefForgotForm');
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