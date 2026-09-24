{{-- resources/views/auth/reset-password.blade.php --}}
<x-guest-layout>
    @section('title')
        {{ 'Nouveau mot de passe' }}
    @endsection

    <br>
    <br>

    <div class="enef-auth">
        <div class="enef-card">

            @include('auth.partials.enef-aside')

            {{-- ===================== FORMULAIRE ===================== --}}
            <main class="enef-main">

                <header class="enef-heading">
                    <span class="enef-badge-icon" aria-hidden="true">
                        <i class="fas fa-unlock-alt"></i>
                    </span>
                    <h1>Nouveau mot de passe</h1>
                    <p class="enef-lead">
                        Vous êtes à une étape de retrouver votre accès. Choisissez un nouveau mot de passe
                        pour votre compte.
                    </p>
                </header>

                {{-- Erreurs (lien expiré ou invalide, mot de passe trop faible, confirmation différente…) --}}
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

                <form method="POST" action="{{ route('password.store') }}" id="enefResetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- EMAIL (lecture seule : fourni par le lien reçu) --}}
                    <div class="enef-group">
                        <label for="email" class="enef-label">Adresse e-mail du compte</label>
                        <div class="enef-field">
                            <i class="fas fa-envelope enef-icon" aria-hidden="true"></i>
                            <input id="email" name="email" type="email"
                                class="enef-input @error('email') is-invalid @enderror"
                                value="{{ old('email', $request->email) }}" required readonly
                                autocomplete="username" @error('email') aria-invalid="true" @enderror>
                        </div>
                    </div>

                    {{-- NOUVEAU MOT DE PASSE --}}
                    <div class="enef-group">
                        <label for="password" class="enef-label">Nouveau mot de passe</label>
                        <div class="enef-field">
                            <i class="fas fa-lock enef-icon" aria-hidden="true"></i>
                            <input id="password" name="password" type="password"
                                class="enef-input @error('password') is-invalid @enderror"
                                placeholder="12 caractères minimum" required autofocus minlength="12"
                                autocomplete="new-password" aria-describedby="enefStrengthText"
                                @error('password') aria-invalid="true" @enderror>
                            <button type="button" class="enef-toggle" data-target="password"
                                aria-label="Afficher le mot de passe" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>

                        {{-- Indicateur de robustesse --}}
                        <div class="enef-meter" aria-hidden="true">
                            <span class="enef-meter-bar" id="enefStrengthBar"></span>
                        </div>
                        <small class="enef-hint" id="enefStrengthText" aria-live="polite">
                            12 caractères minimum. Mélangez majuscules, minuscules, chiffres et symboles pour plus de sécurité.
                        </small>
                    </div>

                    {{-- CONFIRMATION --}}
                    <div class="enef-group">
                        <label for="password_confirmation" class="enef-label">Confirmer le mot de passe</label>
                        <div class="enef-field">
                            <i class="fas fa-lock enef-icon" aria-hidden="true"></i>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="enef-input @error('password_confirmation') is-invalid @enderror"
                                placeholder="Saisissez-le une seconde fois" required autocomplete="new-password"
                                aria-describedby="enefMatchText"
                                @error('password_confirmation') aria-invalid="true" @enderror>
                            <button type="button" class="enef-toggle" data-target="password_confirmation"
                                aria-label="Afficher la confirmation" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <small class="enef-hint" id="enefMatchText" aria-live="polite"></small>
                    </div>

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Réinitialiser le mot de passe</span>
                    </button>
                </form>

                <div class="enef-links" style="margin-top: 1.25rem;">
                    <a href="{{ route('login') }}" class="enef-link">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à la connexion
                    </a>
                </div>

                <p class="enef-security">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    Après la réinitialisation, vous pourrez vous connecter avec votre nouveau mot de passe.
                </p>
            </main>
        </div>
    </div>

    @include('auth.partials.enef-styles')

    <style>
        /* Spécifique à cette page */
        .enef-input[readonly] {
            background: #eef2ee;
            color: #5d6b60;
            cursor: not-allowed;
        }

        .enef-meter {
            height: 6px;
            margin-top: .55rem;
            border-radius: 6px;
            background: #e3e9e4;
            overflow: hidden;
        }

        .enef-meter-bar {
            display: block;
            width: 0;
            height: 100%;
            border-radius: 6px;
            background: #c62828;
            transition: width .3s ease, background-color .3s ease;
        }

        .enef-hint {
            display: block;
            margin-top: .35rem;
            min-height: 1.1em;
            font-size: .76rem;
            color: #7a8a7d;
        }

        .enef-hint.is-ok {
            color: #1e5b26;
        }

        .enef-hint.is-bad {
            color: #8a1c1c;
        }

        @media (prefers-reduced-motion: reduce) {
            .enef-meter-bar {
                transition: none;
            }
        }
    </style>

    <script>
        (function() {
            var pwd = document.getElementById('password');
            var conf = document.getElementById('password_confirmation');
            var bar = document.getElementById('enefStrengthBar');
            var strengthText = document.getElementById('enefStrengthText');
            var matchText = document.getElementById('enefMatchText');
            var defaultHint = strengthText.textContent;
            var MIN = 12; // longueur minimale obligatoire (règle aussi appliquée côté serveur)

            // Afficher / masquer (un bouton par champ)
            document.querySelectorAll('.enef-toggle[data-target]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var input = document.getElementById(btn.getAttribute('data-target'));
                    var visible = input.type === 'password';
                    input.type = visible ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', visible ? 'true' : 'false');
                    btn.querySelector('i').className = visible ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            });

            // Robustesse du mot de passe (indicatif : la règle réelle est appliquée par le serveur)
            var niveaux = [
                { txt: 'Très faible', color: '#c62828' },
                { txt: 'Faible', color: '#e65100' },
                { txt: 'Moyen', color: '#f9a825' },
                { txt: 'Bon', color: '#7cb342' },
                { txt: 'Excellent', color: '#2e7d32' }
            ];

            function score(v) {
                var s = 0;
                if (v.length >= MIN) s++;
                if (v.length >= 16) s++;
                if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s++;
                if (/\d/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                return s; // 0 à 5
            }

            function majRobustesse() {
                var v = pwd.value;
                if (!v) {
                    bar.style.width = '0';
                    strengthText.textContent = defaultHint;
                    strengthText.className = 'enef-hint';
                    return;
                }
                // Longueur insuffisante : on indique combien de caractères manquent
                if (v.length < MIN) {
                    var reste = MIN - v.length;
                    bar.style.width = (v.length / MIN * 100) + '%';
                    bar.style.backgroundColor = niveaux[0].color;
                    strengthText.textContent = 'Encore ' + reste + ' caractère' + (reste > 1 ? 's' : '') +
                        ' pour atteindre le minimum de ' + MIN + '.';
                    strengthText.className = 'enef-hint is-bad';
                    return;
                }

                var s = Math.max(Math.min(score(v), 5), 1); // au moins 1 pour que la barre reste visible
                var niveau = niveaux[s - 1];
                bar.style.width = (s / 5 * 100) + '%';
                bar.style.backgroundColor = niveau.color;
                strengthText.textContent = 'Robustesse : ' + niveau.txt;
                strengthText.className = 'enef-hint';
            }

            function majCorrespondance() {
                if (!conf.value) {
                    matchText.textContent = '';
                    matchText.className = 'enef-hint';
                    return;
                }
                var ok = conf.value === pwd.value;
                matchText.textContent = ok ? 'Les mots de passe correspondent.' : 'Les mots de passe ne correspondent pas.';
                matchText.className = 'enef-hint ' + (ok ? 'is-ok' : 'is-bad');
            }

            pwd.addEventListener('input', function() { majRobustesse(); majCorrespondance(); });
            conf.addEventListener('input', majCorrespondance);

            // Envoi : blocage si les deux champs diffèrent, sinon état "chargement"
            var form = document.getElementById('enefResetForm');
            var btn = document.getElementById('enefSubmit');
            var label = btn.querySelector('.enef-btn-label');
            var spinner = btn.querySelector('.enef-spinner');
            var texte = label.textContent;

            form.addEventListener('submit', function(e) {
                if (pwd.value.length < MIN) {
                    e.preventDefault();
                    majRobustesse();
                    pwd.focus();
                    return;
                }

                if (pwd.value !== conf.value) {
                    e.preventDefault();
                    majCorrespondance();
                    conf.focus();
                    return;
                }
                btn.disabled = true;
                label.textContent = 'Enregistrement…';
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
        })();
    </script>
</x-guest-layout>