<x-admin>
    @section('title', 'Statistiques des fonctionnalités')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Sous-titre --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <p class="text-muted mb-1">
                Vue d'ensemble chiffrée du contenu et des fonctionnalités gérés sur le site,
                pour la période choisie (comptage selon la date de création, de soumission ou de
                publication ; les téléchargements de documents sont comptés à leur date réelle).
                Les référentiels sans date (matières, catégories de documents,
                partenaires) restent affichés en total global.
            </p>
        </div>
    </div>

    {{-- Filtre : période + année --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex flex-wrap align-items-center">
            <div class="btn-group btn-group-sm flex-wrap mr-3" role="group" aria-label="Filtre de période">
                @foreach($periodes as $cle => $libelle)
                    <a href="{{ route('admin.statistiques.fonctionnalites', ['periode' => $cle, 'annee' => $annee]) }}"
                        class="btn {{ $periode === $cle ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $libelle }}
                    </a>
                @endforeach
            </div>

            <form method="get" action="{{ route('admin.statistiques.fonctionnalites') }}" class="d-inline-flex align-items-center mb-0">
                <input type="hidden" name="periode" value="{{ $periode }}">
                <label for="annee" class="text-muted small mb-0 mr-1">Année :</label>
                <select name="annee" id="annee" class="form-control form-control-sm d-inline-block" style="width:auto" onchange="this.form.submit()">
                    @foreach($annees as $an)
                        <option value="{{ $an }}" @selected((int) $an === (int) $annee)>{{ $an }}</option>
                    @endforeach
                </select>
            </form>

            <span class="small text-muted ml-3">
                Du {{ \Illuminate\Support\Carbon::parse($debut)->translatedFormat('d M Y') }}
                au {{ \Illuminate\Support\Carbon::parse($fin)->translatedFormat('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Cartes récapitulatives --}}
    <div class="row">
        @foreach($cartes as $carte)
            <div class="col-lg-3 col-md-6 col-12 mb-3">
                @if(Route::has($carte['route']))
                    <a href="{{ route($carte['route']) }}" class="d-block text-decoration-none">
                @endif
                <div class="small-box bg-{{ $carte['couleur'] }}">
                    <div class="inner">
                        <h3>{{ number_format($carte['valeur'], 0, ',', ' ') }}</h3>
                        <p>{{ $carte['libelle'] }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas {{ $carte['icone'] }}"></i>
                    </div>
                </div>
                @if(Route::has($carte['route']))
                    </a>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Graphiques --}}
    <div class="row">
        <div class="col-md-7">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Contenu par module</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="fonctionnalitesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Utilisateurs par rôle</h3>
                </div>
                <div class="card-body">
                    @if(!empty($chartRoles['donnees']))
                        <div style="height: 300px;">
                            <canvas id="rolesChart"></canvas>
                        </div>
                    @else
                        <p class="text-center text-muted py-4 mb-0">Aucun utilisateur enregistré.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Détails par fonctionnalité --}}
    <div class="row">
        @foreach($modules as $module)
            <div class="col-md-6">
                <div class="card card-outline card-{{ $module['couleur'] }} mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas {{ $module['icone'] }} mr-2"></i>{{ $module['titre'] }}
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-borderless table-striped mb-0">
                            <tbody>
                                @foreach($module['lignes'] as $ligne)
                                    <tr>
                                        <td class="text-muted pl-3">{{ $ligne[0] }}</td>
                                        <td class="text-right pr-3 font-weight-bold">
                                            {{ number_format($ligne[1], 0, ',', ' ') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if(!empty($module['repartition']['items']))
                            <div class="px-3 py-2 border-top">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-layer-group mr-1"></i>{{ $module['repartition']['titre'] }}
                                </small>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        @foreach($module['repartition']['items'] as $item)
                                            <tr>
                                                <td class="pl-0">{{ $item[0] }}</td>
                                                <td class="text-right">
                                                    <span class="badge badge-light border">{{ number_format($item[1], 0, ',', ' ') }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif(isset($module['repartition']['vide']))
                            <p class="text-muted small px-3 py-2 border-top mb-0">
                                {{ $module['repartition']['vide'] }}
                            </p>
                        @endif

                        @if(!empty($module['referentiels_globaux']))
                            <div class="px-3 py-2 border-top">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-info-circle mr-1"></i>Référentiels (totaux, hors période)
                                </small>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        @foreach($module['referentiels_globaux'] as $item)
                                            <tr>
                                                <td class="pl-0">{{ $item[0] }}</td>
                                                <td class="text-right">
                                                    <span class="badge badge-light border">{{ number_format($item[1], 0, ',', ' ') }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    @if(!empty($module['routes']))
                        <div class="card-footer py-2">
                            @foreach($module['routes'] as $lien)
                                @if(Route::has($lien[1]))
                                    <a href="{{ route($lien[1]) }}" class="small mr-3 text-muted">
                                        <i class="fas fa-external-link-alt mr-1"></i>{{ $lien[0] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var contenu = @json($chartContenus);
            var ctx1 = document.getElementById('fonctionnalitesChart').getContext('2d');

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: contenu.labels,
                    datasets: [{
                        label: 'Éléments',
                        data: contenu.donnees,
                        backgroundColor: 'rgba(60,141,188,0.8)',
                        borderColor: 'rgba(60,141,188,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            @if(!empty($chartRoles['donnees']))
                var roles = @json($chartRoles);
                var ctx2 = document.getElementById('rolesChart').getContext('2d');

                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: roles.labels,
                        datasets: [{
                            data: roles.donnees,
                            backgroundColor: roles.couleurs,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            @endif
        });
    </script>
    @endsection
</x-admin>