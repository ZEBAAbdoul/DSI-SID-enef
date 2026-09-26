{{-- resources/views/candidat/inscription.blade.php --}}

{{-- NB : @section() ne fonctionne pas dans un composant <x-admin>.
     Adapter selon ton composant : attribut `title` (ci-dessous)
     ou <x-slot name="title">Mon dossier de candidature</x-slot> --}}
<x-admin title="Mon dossier de candidature">

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$inscription)
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="mb-3">Vous n'avez pas encore de dossier de candidature.</p>
                <a href="{{ route('admin.inscription.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Choisir une session
                </a>
            </div>
        </div>
    @else
        @php
            $badgesStatut = [
                'depose' => 'badge-secondary',
                'en_cours' => 'badge-info',
                'incomplet' => 'badge-warning',
                'valide' => 'badge-success',
                'rejete' => 'badge-danger',
            ];
            $labelsStatut = [
                'depose' => 'Déposé',
                'en_cours' => 'En cours',
                'incomplet' => 'Incomplet',
                'valide' => 'Validé',
                'rejete' => 'Rejeté',
            ];
            $piecesParType = $inscription->pieces->groupBy('type_piece');
        @endphp

        {{-- En-tête du dossier --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    Dossier {{ $inscription->numero_dossier ?? '—' }}
                </h3>

                <span class="badge {{ $badgesStatut[$inscription->statut] ?? 'badge-secondary' }}">
                    {{ $labelsStatut[$inscription->statut] ?? $inscription->statut }}
                </span>
            </div>

            <div class="card-body">

                {{-- Message affiché uniquement si la candidature est validée (ANIMÉ) --}}
                @if ($inscription->statut === 'valide')
                    @php
                        $contactRh = $parametresSite->contact_rh ?? null;
                        // Numéro nettoyé pour le lien tel: (chiffres et + uniquement)
                        $telRh = $contactRh ? preg_replace('/[^\d+]/', '', $contactRh) : null;

                        // Confettis : positions/couleurs déterministes (pas d'aléatoire → rendu stable)
                        $couleursConfettis = ['#ffd166', '#ffffff', '#ef476f', '#06d6a0', '#4cc9f0', '#ffb703'];
                    @endphp

                    <div class="validation-banner mb-4" role="status">

                        {{-- Confettis (décor) --}}
                        <div class="vb-confetti" aria-hidden="true">
                            @for ($i = 0; $i < 32; $i++)
                                <i style="--l: {{ ($i * 37 + 11) % 100 }}%;
                                          --d: {{ number_format((($i * 7) % 14) / 10, 1) }}s;
                                          --c: {{ $couleursConfettis[$i % count($couleursConfettis)] }};
                                          --s: {{ 6 + ($i % 4) * 2 }}px;
                                          --r: {{ 360 + (($i * 53) % 540) }}deg;
                                          --dx: {{ ($i % 2 ? 1 : -1) * (($i * 13) % 70) }}px;"></i>
                            @endfor
                        </div>

                        {{-- Décor : toque flottante --}}
                        <i class="fas fa-graduation-cap vb-watermark" aria-hidden="true"></i>

                        <div class="vb-content d-flex flex-column flex-md-row align-items-center text-center text-md-left">

                            {{-- Coche SVG qui se dessine --}}
                            <div class="vb-icon mb-3 mb-md-0 mr-md-4" aria-hidden="true">
                                <svg viewBox="0 0 52 52" class="vb-check">
                                    <circle class="vb-check-circle" cx="26" cy="26" r="24" fill="none" />
                                    <path class="vb-check-mark" fill="none" d="M14 27l8 8 16-17" />
                                </svg>
                            </div>

                            <div>
                                <h4 class="vb-title vb-line vb-d1">
                                    Félicitations ! Votre inscription a été validée.
                                </h4>

                                <p class="vb-line vb-d2 mb-2">
                                    Votre candidature a été retenue pour cette formation.
                                </p>

                                <p class="vb-line vb-d3 mb-0">
                                    Pour procéder au <strong>paiement des frais de scolarité</strong>,
                                    veuillez contacter le
                                    <strong>Agence comptable</strong> au numéro :
                                </p>

                                @if ($contactRh)
                                    <div class="vb-line vb-d4 mt-3">
                                        <a href="tel:{{ $telRh }}" class="btn btn-light vb-call">
                                            <i class="fas fa-phone-alt vb-phone"></i>
                                            {{ $contactRh }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Styles inline (ne dépend pas d'un @stack dans le layout), émis seulement si validé --}}
                    <style>
                        /* ---------- Bannière ---------- */
                        .validation-banner {
                            position: relative;
                            overflow: hidden;
                            padding: 1.75rem 1.5rem;
                            border-radius: .85rem;
                            color: #fff;
                            background: linear-gradient(120deg, #146c43, #198754, #0f766e, #146c43);
                            background-size: 300% 300%;
                            box-shadow: 0 10px 28px rgba(25, 135, 84, .35);
                            animation:
                                vb-in .9s cubic-bezier(.34, 1.56, .64, 1) both,
                                vb-gradient 9s ease-in-out 1s infinite,
                                vb-glow 3s ease-in-out 1.2s infinite;
                        }

                        .vb-content {
                            position: relative;
                            z-index: 2;
                        }

                        .vb-title {
                            font-weight: 800;
                            margin-bottom: .6rem;
                            text-shadow: 0 1px 2px rgba(0, 0, 0, .25);
                        }

                        /* ---------- Coche SVG ---------- */
                        .vb-icon {
                            position: relative;
                            flex-shrink: 0;
                            width: 84px;
                            height: 84px;
                            border-radius: 50%;
                            background: rgba(255, 255, 255, .16);
                            animation: vb-pop .7s cubic-bezier(.34, 1.56, .64, 1) .2s both;
                        }

                        .vb-icon::before,
                        .vb-icon::after {
                            content: "";
                            position: absolute;
                            inset: 0;
                            border-radius: 50%;
                            border: 2px solid rgba(255, 255, 255, .8);
                            opacity: 0;
                            animation: vb-ring 2.6s ease-out 1.3s infinite;
                        }

                        .vb-icon::after {
                            animation-delay: 2.2s;
                        }

                        .vb-check {
                            display: block;
                            width: 100%;
                            height: 100%;
                            padding: 12px;
                        }

                        .vb-check-circle {
                            stroke: #fff;
                            stroke-width: 3;
                            stroke-dasharray: 151;
                            stroke-dashoffset: 151;
                            animation: vb-draw .7s ease-out .35s forwards;
                        }

                        .vb-check-mark {
                            stroke: #fff;
                            stroke-width: 4;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-dasharray: 40;
                            stroke-dashoffset: 40;
                            animation: vb-draw .45s ease-out 1s forwards;
                        }

                        /* ---------- Texte en cascade ---------- */
                        .vb-line {
                            animation: vb-up .55s ease-out both;
                        }

                        .vb-d1 { animation-delay: .45s; }
                        .vb-d2 { animation-delay: .6s; }
                        .vb-d3 { animation-delay: .75s; }
                        .vb-d4 { animation-delay: .9s; }

                        /* ---------- Bouton d'appel ---------- */
                        .vb-call {
                            font-weight: 700;
                            color: #146c43;
                            border-radius: 50rem;
                            padding: .45rem 1.1rem;
                            animation: vb-pulse 2.2s ease-out 1.6s infinite;
                        }

                        .vb-call:hover,
                        .vb-call:focus {
                            color: #0f5132;
                            animation: none;
                            transform: translateY(-1px);
                        }

                        .vb-phone {
                            display: inline-block;
                            transform-origin: 50% 50%;
                            animation: vb-ringing 3.5s ease-in-out 2s infinite;
                        }

                        /* ---------- Décor ---------- */
                        .vb-watermark {
                            position: absolute;
                            z-index: 1;
                            right: 1.25rem;
                            bottom: -.5rem;
                            font-size: 7.5rem;
                            color: rgba(255, 255, 255, .12);
                            pointer-events: none;
                            animation: vb-float 5s ease-in-out infinite;
                        }

                        .vb-confetti {
                            position: absolute;
                            inset: 0;
                            z-index: 3;
                            pointer-events: none;
                            overflow: hidden;
                        }

                        .vb-confetti i {
                            position: absolute;
                            top: -14px;
                            left: var(--l);
                            width: var(--s);
                            height: calc(var(--s) * 1.7);
                            background: var(--c);
                            border-radius: 2px;
                            opacity: 0;
                            animation: vb-fall 2.9s cubic-bezier(.25, .6, .4, 1) var(--d) 1 forwards;
                        }

                        @media (max-width: 767px) {
                            .vb-watermark { font-size: 5rem; }
                        }

                        /* ---------- Keyframes ---------- */
                        @keyframes vb-in {
                            from { opacity: 0; transform: translateY(-28px) scale(.92); }
                            to   { opacity: 1; transform: none; }
                        }

                        @keyframes vb-gradient {
                            0%, 100% { background-position: 0% 50%; }
                            50%      { background-position: 100% 50%; }
                        }

                        @keyframes vb-glow {
                            0%, 100% { box-shadow: 0 10px 28px rgba(25, 135, 84, .30); }
                            50%      { box-shadow: 0 14px 42px rgba(25, 135, 84, .55); }
                        }

                        @keyframes vb-pop {
                            from { opacity: 0; transform: scale(0) rotate(-90deg); }
                            to   { opacity: 1; transform: scale(1) rotate(0); }
                        }

                        @keyframes vb-draw {
                            to { stroke-dashoffset: 0; }
                        }

                        @keyframes vb-ring {
                            0%   { opacity: .7; transform: scale(.85); }
                            100% { opacity: 0;  transform: scale(1.8); }
                        }

                        @keyframes vb-up {
                            from { opacity: 0; transform: translateY(10px); }
                            to   { opacity: 1; transform: none; }
                        }

                        @keyframes vb-pulse {
                            0%   { box-shadow: 0 0 0 0 rgba(255, 255, 255, .65); }
                            70%  { box-shadow: 0 0 0 14px rgba(255, 255, 255, 0); }
                            100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
                        }

                        @keyframes vb-ringing {
                            0%, 60%, 100% { transform: rotate(0); }
                            64% { transform: rotate(-20deg); }
                            68% { transform: rotate(18deg); }
                            72% { transform: rotate(-16deg); }
                            76% { transform: rotate(14deg); }
                            80% { transform: rotate(-8deg); }
                            84% { transform: rotate(6deg); }
                        }

                        @keyframes vb-float {
                            0%, 100% { transform: translateY(0) rotate(-8deg); }
                            50%      { transform: translateY(-12px) rotate(-3deg); }
                        }

                        @keyframes vb-fall {
                            0%   { opacity: 1; transform: translate3d(0, 0, 0) rotate(0); }
                            80%  { opacity: 1; }
                            100% { opacity: 0; transform: translate3d(var(--dx), 340px, 0) rotate(var(--r)); }
                        }

                        /* Accessibilité : pas de mouvement, mais la coche reste visible */
                        @media (prefers-reduced-motion: reduce) {
                            .validation-banner,
                            .vb-icon,
                            .vb-icon::before,
                            .vb-icon::after,
                            .vb-line,
                            .vb-call,
                            .vb-phone,
                            .vb-watermark {
                                animation: none !important;
                            }

                            .vb-check-circle,
                            .vb-check-mark {
                                animation: none !important;
                                stroke-dashoffset: 0;
                            }

                            .vb-confetti {
                                display: none;
                            }
                        }
                    </style>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Formation :</strong>
                            {{ $inscription->formation->titre ?? 'Formation supprimée' }}
                        </p>

                        <p class="mb-1">
                            <strong>Lieu :</strong>
                            {{ $inscription->session->lieu ?? '—' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Session :</strong>

                            @if ($inscription->session)
                                {{ \Carbon\Carbon::parse($inscription->session->date_debut)->format('d/m/Y') }}
                                →
                                {{ $inscription->session->date_fin
                                    ? \Carbon\Carbon::parse($inscription->session->date_fin)->format('d/m/Y')
                                    : '—' }}
                            @else
                                —
                            @endif
                        </p>

                        <p class="mb-1">
                            <strong>Soumis le :</strong>
                            {{ $inscription->date_soumission
                                ? \Carbon\Carbon::parse($inscription->date_soumission)->format('d/m/Y à H:i')
                                : '—' }}
                        </p>
                    </div>
                </div>

                @if ($inscription->statut === 'rejete' && $inscription->motif_rejet)
                    <div class="alert alert-danger mt-3 mb-0">
                        <strong>Motif du rejet :</strong>
                        {{ $inscription->motif_rejet }}
                    </div>
                @endif
            </div>
        </div>


        {{-- Pièces justificatives --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pièces justificatives</h3>
            </div>
            <div class="card-body">
                @if ($typesPieces->isEmpty())
                    <p class="text-muted mb-0">Aucun type de pièce configuré.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>PIÈCE</th>
                                    <th>STATUT</th>
                                    <th>FICHIER(S)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($typesPieces as $type)
                                    @php
                                        $piecesDuType = $piecesParType->get($type->code, collect());
                                        $derniere = $piecesDuType->last();
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $type->libelle }}
                                            @if ($type->obligatoire)
                                                <span class="badge badge-danger ml-1">Obligatoire</span>
                                            @else
                                                <span class="badge badge-secondary ml-1">Facultatif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($piecesDuType->isEmpty())
                                                <span class="badge badge-light border">Non déposée</span>
                                            @elseif ($derniere->estConforme())
                                                <span class="badge badge-success">Conforme</span>
                                            @elseif ($derniere->estNonConforme())
                                                <span class="badge badge-danger">Non conforme</span>
                                            @else
                                                <span class="badge badge-warning">En attente de vérification</span>
                                            @endif
                                            @if ($derniere && $derniere->estNonConforme() && $derniere->commentaire)
                                                <div class="small text-danger mt-1">{{ $derniere->commentaire }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse ($piecesDuType as $piece)
                                                <div class="d-flex align-items-center mb-1">
                                                    <a href="{{ route('admin.inscription.piece.telecharger', $piece) }}"
                                                        class="mr-2">
                                                        <i class="fas fa-file"></i>
                                                        {{ strtoupper($piece->format_fichier) }} ·
                                                        {{ $piece->taille_fichier_ko }} Ko
                                                    </a>

                                                    @if ($inscription->statut !== 'valide')
                                                        {{-- Bouton Modifier : uniquement si la pièce n'est PAS conforme --}}
                                                        @if (!$piece->estConforme())
                                                            <button type="button" class="btn btn-sm btn-link p-0 mr-2"
                                                                data-toggle="collapse"
                                                                data-target="#modifier-{{ $piece->id }}">
                                                                <i class="fas fa-pen"></i> Modifier
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>

                                                {{-- Formulaire de remplacement (masqué par défaut) --}}
                                                @if ($inscription->statut !== 'valide' && !$piece->estConforme())
                                                    <div id="modifier-{{ $piece->id }}" class="collapse mt-1 mb-2">
                                                        <form
                                                            action="{{ route('admin.inscription.piece.update', $piece) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="form-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="file" name="fichier"
                                                                class="form-control-file mr-2"
                                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-upload"></i> Remplacer
                                                            </button>
                                                        </form>
                                                        @error('fichier')
                                                            <small
                                                                class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @endif
                                            @empty
                                                <span class="text-muted">—</span>
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <small class="form-text text-muted">
                        Formats acceptés : PDF, JPG, PNG — 5 Mo max par fichier.
                    </small>
                @endif
            </div>
        </div>
    @endif
</x-admin>