<x-admin>
    @section('title', $formation->titre)

    <div class="container-fluid">

        {{-- En-tête --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title mb-0">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    {{ $formation->titre }}
                </h3>

                <span class="badge {{ $formation->statut_badge }}">
                    {{ $formation->statut_libelle }}
                </span>

            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Image --}}
                    <div class="col-md-4">

                        @if ($formation->image_url)

                            <img src="{{ asset($formation->image_url) }}"
                                 alt="{{ $formation->titre }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="width:100%; max-height:300px; object-fit:cover;">

                        @else

                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="height:250px;">

                                <div class="text-center text-muted">
                                    <i class="fas fa-graduation-cap fa-4x mb-3"></i>
                                    <p>Aucune image</p>
                                </div>

                            </div>

                        @endif

                    </div>

                    {{-- Informations --}}
                    <div class="col-md-8">

                        <h2 class="mb-3">
                            {{ $formation->titre }}
                        </h2>

                        @if ($formation->resume)
                            <p class="text-muted">
                                {{ $formation->resume }}
                            </p>
                        @endif

                        <hr>

                        <div class="row">

                            <div class="col-md-6">
                                <p>
                                    <strong>
                                        <i class="fas fa-layer-group mr-1"></i>
                                        Type :
                                    </strong>

                                    {{ $formation->type_libelle }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-sitemap mr-1"></i>
                                        Catégorie :
                                    </strong>

                                    {{ $formation->categorie->nom ?? '—' }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-project-diagram mr-1"></i>
                                        Filière :
                                    </strong>

                                    {{ $formation->filiere->nom ?? '—' }}
                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>
                                    <strong>
                                        <i class="fas fa-clock mr-1"></i>
                                        Durée :
                                    </strong>

                                    {{ $formation->duree_formatee }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Coût :
                                    </strong>

                                    {{ $formation->cout_formate }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-user mr-1"></i>
                                        Créée par :
                                    </strong>

                                    {{ $formation->createur->name ?? '—' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <hr>

                {{-- Objectifs --}}
                @if ($formation->objectifs)

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-bullseye mr-2 text-primary"></i>
                            Objectifs de la formation
                        </h4>

                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($formation->objectifs)) !!}
                        </div>

                    </div>

                @endif

                {{-- Contenu --}}
                @if ($formation->contenu_programme)

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-book-open mr-2 text-primary"></i>
                            Contenu du programme
                        </h4>

                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($formation->contenu_programme)) !!}
                        </div>

                    </div>

                @endif

                {{-- Public cible --}}
                @if ($formation->public_cible)

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-users mr-2 text-primary"></i>
                            Public cible
                        </h4>

                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($formation->public_cible)) !!}
                        </div>

                    </div>

                @endif

                {{-- Mots-clés --}}
                @if ($formation->mots_cles_array)

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-tags mr-2 text-primary"></i>
                            Mots-clés
                        </h4>

                        @foreach ($formation->mots_cles_array as $mot)
                            <span class="badge badge-secondary mr-1 mb-1">
                                {{ $mot }}
                            </span>
                        @endforeach

                    </div>

                @endif

            </div>

        </div>


        {{-- Sessions --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Sessions de cette formation
                </h3>

                @unless(auth()->user()->hasRole('user'))
                    <a href="{{ route('admin.sessions-formation.create', ['formation_id' => $formation->id]) }}"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Nouvelle session
                    </a>
                @endunless

            </div>

            <div class="card-body">

                @if ($formation->sessions->count())

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">

                                <tr>
                                    <th>Dates</th>
                                    <th>Lieu</th>
                                    <th>Places</th>
                                    <th>Statut</th>
                                    <th width="100">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($formation->sessions as $session)

                                    <tr>

                                        <td>

                                            {{ \Carbon\Carbon::parse($session->date_debut)->format('d/m/Y') }}

                                            @if ($session->date_fin)
                                                →
                                                {{ \Carbon\Carbon::parse($session->date_fin)->format('d/m/Y') }}
                                            @endif

                                        </td>

                                        <td>
                                            {{ $session->lieu ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $session->places_disponibles ?? '—' }}
                                        </td>

                                        <td>

                                            @php
                                                $badge = match ($session->statut) {
                                                    'ouverte' => 'badge-success',
                                                    'cloturee' => 'badge-danger',
                                                    'brouillon' => 'badge-warning',
                                                    default => 'badge-secondary',
                                                };
                                            @endphp

                                            <span class="badge {{ $badge }}">
                                                {{ ucfirst($session->statut) }}
                                            </span>

                                        </td>

                                        <td>

                                            <a href="{{ route('admin.sessions-formation.edit', $session) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Modifier">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i class="fas fa-calendar-times fa-3x mb-3"></i>

                        <p class="mb-0">
                            Aucune session n'est encore associée à cette formation.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Actions --}}
        <div class="mt-3 mb-4">

            <a href="{{ route('admin.formations.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Retour aux formations

            </a>

            @unless(auth()->user()->hasRole('user'))

                <a href="{{ route('admin.formations.edit', $formation) }}"
                   class="btn btn-warning">

                    <i class="fas fa-edit mr-1"></i>
                    Modifier

                </a>

            @endunless

        </div>
        <br>

    </div>
</x-admin>