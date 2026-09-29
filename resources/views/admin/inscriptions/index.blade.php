{{-- resources/views/admin/inscriptions/index.blade.php --}}

{{-- NB : @section() ne fonctionne pas dans un composant <x-admin>.
     Adapter selon ton composant : attribut `title` (ci-dessous)
     ou <x-slot name="title">Candidatures</x-slot> --}}
<x-admin title="Candidatures">

    {{-- Message de session --}}
    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Message d'erreur --}}
    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}
        </div>
    @endif


    <div class="card">

        {{-- ================================
             EN-TÊTE + FILTRES
        ================================= --}}
        @php
    $statutsFiltres = [
        'depose'    => 'Déposé',
        'en_cours'  => 'En cours',
        'incomplet' => 'Incomplet',
        'valide'    => 'Validé',
        'rejete'    => 'Rejeté',
    ];
    $filtresActifs = request()->filled('q') || request()->filled('session_id')
        || request()->filled('statut') || request()->filled('du') || request()->filled('au');
@endphp

<div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-file-alt mr-2"></i>
        Liste des candidatures
        <span class="badge badge-secondary ml-2">{{ $inscriptions->total() }}</span>
    </h3>
</div>

{{-- ================= FILTRES ================= --}}
<div class="card-body border-bottom pb-2">

    {{-- Pastilles de statut --}}
    <div class="mb-3">
        <a href="{{ route('admin.inscriptions.index', request()->except('statut', 'page')) }}"
           class="btn btn-sm rounded-pill mr-1 mb-1 {{ request('statut') ? 'btn-outline-secondary' : 'btn-primary' }}">
            Tous <span class="badge badge-light ml-1">{{ $comptes->sum() }}</span>
        </a>

        @foreach ($statutsFiltres as $valeur => $libelle)
            <a href="{{ route('admin.inscriptions.index', array_merge(request()->except('statut', 'page'), ['statut' => $valeur])) }}"
               class="btn btn-sm rounded-pill mr-1 mb-1 {{ request('statut') === $valeur ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ $libelle }}
                <span class="badge badge-light ml-1">{{ $comptes[$valeur] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    <form action="{{ route('admin.inscriptions.index') }}" method="GET">
        @if (request()->filled('statut'))
            <input type="hidden" name="statut" value="{{ request('statut') }}">
        @endif

        <div class="form-row align-items-end">

            {{-- Recherche texte --}}
            <div class="form-group col-lg-4 col-md-12">
                <label for="filtre-q" class="small text-muted mb-1">Recherche</label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="search" id="filtre-q" name="q" value="{{ request('q') }}"
                           class="form-control" placeholder="N° dossier, nom, e-mail, téléphone…"
                           autocomplete="off">
                </div>
            </div>

            {{-- Session --}}
            <div class="form-group col-lg-3 col-md-6">
                <label for="filtre-session" class="small text-muted mb-1">Session</label>
                <select id="filtre-session" name="session_id" class="form-control form-control-sm">
                    <option value="">Toutes les sessions</option>
                    @foreach ($sessions as $sessionOption)
                        @php
                            $debut = $sessionOption->date_debut
                                ? \Carbon\Carbon::parse($sessionOption->date_debut)->format('d/m/Y') : '—';
                            $fin = $sessionOption->date_fin
                                ? \Carbon\Carbon::parse($sessionOption->date_fin)->format('d/m/Y') : '—';
                        @endphp
                        <option value="{{ $sessionOption->id }}" @selected((string) request('session_id') === (string) $sessionOption->id)>
                            {{ $sessionOption->formation->titre ?? 'Formation' }} — {{ $debut }} au {{ $fin }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Période de dépôt --}}
            <div class="form-group col-lg-2 col-md-3 col-6">
                <label for="filtre-du" class="small text-muted mb-1">Déposé du</label>
                <input type="date" id="filtre-du" name="du" value="{{ request('du') }}"
                       class="form-control form-control-sm @error('du') is-invalid @enderror">
            </div>

            <div class="form-group col-lg-2 col-md-3 col-6">
                <label for="filtre-au" class="small text-muted mb-1">au</label>
                <input type="date" id="filtre-au" name="au" value="{{ request('au') }}"
                       class="form-control form-control-sm @error('au') is-invalid @enderror">
            </div>

            {{-- Boutons --}}
            <div class="form-group col-lg-1 col-12 text-lg-right">
                <button type="submit" class="btn btn-sm btn-primary" title="Rechercher">
                    <i class="fas fa-search"></i>
                    <span class="d-lg-none ml-1">Rechercher</span>
                </button>
            </div>
        </div>

        @if ($filtresActifs)
            <div class="mb-2">
                <a href="{{ route('admin.inscriptions.index') }}" class="small text-secondary">
                    <i class="fas fa-times mr-1"></i> Réinitialiser les filtres
                </a>
            </div>
        @endif
    </form>
</div>


        {{-- ================================
             TABLEAU
        ================================= --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>N° DOSSIER</th>
                            <th>CANDIDAT</th>
                            <th>FORMATION</th>
                            <th>SESSION</th>
                            <th>DÉPOSÉ LE</th>
                            <th>STATUT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($inscriptions as $inscription)
                            <tr>

                                {{-- N° DOSSIER --}}
                                <td>
                                    <strong>
                                        {{ $inscription->numero_dossier }}
                                    </strong>
                                </td>


                                {{-- CANDIDAT --}}
                                <td>
                                    <div class="candidate-name">
                                        <i class="fas fa-user mr-1 text-muted"></i>

                                        {{ $inscription->candidat->name ?? ($inscription->candidat->email ?? 'Candidat inconnu') }}
                                    </div>
                                </td>


                                {{-- FORMATION --}}
                                <td>
                                    {{ $inscription->formation->titre ?? '—' }}
                                </td>


                                {{-- SESSION --}}
                                <td>

                                    @if ($inscription->session)
                                        <span class="date-session">
                                            <i class="far fa-calendar-alt mr-1"></i>

                                            {{ \Carbon\Carbon::parse($inscription->session->date_debut)->format('d/m/Y') }}
                                            au
                                            {{ \Carbon\Carbon::parse($inscription->session->date_fin)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        —
                                    @endif

                                </td>


                                {{-- DATE DE SOUMISSION --}}
                                <td>

                                    @if ($inscription->date_soumission)
                                        {{ $inscription->date_soumission->format('d/m/Y') }}
                                    @else
                                        —
                                    @endif

                                </td>


                                {{-- STATUT --}}
                                <td>

                                    @php

                                        $statutConfig = [
                                            'depose' => [
                                                'label' => 'Déposé',
                                                'icon' => 'fas fa-file-upload',
                                                'class' => 'statut-depose',
                                            ],

                                            'en_cours' => [
                                                'label' => 'En cours',
                                                'icon' => 'fas fa-hourglass-half',
                                                'class' => 'statut-en-cours',
                                            ],

                                            'incomplet' => [
                                                'label' => 'Incomplète',
                                                'icon' => 'fas fa-exclamation-circle',
                                                'class' => 'statut-incomplet',
                                            ],

                                            'valide' => [
                                                'label' => 'Validée',
                                                'icon' => 'fas fa-check-circle',
                                                'class' => 'statut-valide',
                                            ],

                                            'rejete' => [
                                                'label' => 'Rejetée',
                                                'icon' => 'fas fa-times-circle',
                                                'class' => 'statut-rejete',
                                            ],
                                        ];

                                        $statut = $statutConfig[$inscription->statut] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $inscription->statut)),
                                            'icon' => 'fas fa-info-circle',
                                            'class' => 'statut-default',
                                        ];

                                    @endphp

                                    <span class="statut-badge {{ $statut['class'] }}">

                                        <i class="{{ $statut['icon'] }}"></i>

                                        {{ $statut['label'] }}

                                    </span>

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    <a href="{{ route('admin.inscriptions.show', $inscription) }}"
                                        class="btn btn-sm btn-info">

                                        <i class="fas fa-eye"></i>

                                        Voir

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center text-muted py-4">

                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>

                                    Aucune candidature trouvée.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION (les filtres sont conservés via withQueryString() dans le contrôleur) --}}
        <div class="card-footer">

            {{ $inscriptions->links() }}

        </div>

    </div>


    {{-- STYLE DES STATUTS (inline : ne dépend pas d'un @stack('styles') dans le layout) --}}
    <style>
        .statut-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            border: 1px solid transparent;
            transition: all .2s ease;
        }

        .statut-badge i {
            font-size: 12px;
        }

        .statut-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, .08);
        }

        .statut-depose {
            color: #075985;
            background: #e0f2fe;
            border-color: #7dd3fc;
        }

        .statut-depose i {
            color: #0284c7;
        }

        .statut-en-cours {
            color: #92400e;
            background: #fffbeb;
            border-color: #fcd34d;
        }

        .statut-en-cours i {
            color: #f59e0b;
        }

        .statut-incomplet {
            color: #1e40af;
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .statut-incomplet i {
            color: #2563eb;
        }

        .statut-valide {
            color: #166534;
            background: #ecfdf3;
            border-color: #86efac;
        }

        .statut-valide i {
            color: #16a34a;
        }

        .statut-rejete {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .statut-rejete i {
            color: #dc2626;
        }

        .statut-default {
            color: #374151;
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .statut-default i {
            color: #6b7280;
        }

        .candidate-name {
            font-weight: 500;
        }

        .date-session {
            white-space: nowrap;
        }
    </style>
    <br>

</x-admin>
