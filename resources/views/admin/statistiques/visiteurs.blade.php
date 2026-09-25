<x-admin>
    @section('title', 'Statistiques des visiteurs')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Sous-titre — le titre est déjà affiché par l'en-tête AdminLTE --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <p class="text-muted mb-1">
                Pages visitées, lieux des visiteurs et fréquentation par période.
            </p>
        </div>
    </div>

    {{-- Filtre : période + année --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex flex-wrap align-items-center">
            <div class="btn-group btn-group-sm flex-wrap mr-3" role="group" aria-label="Filtre de période">
                @foreach($periodes as $cle => $libelle)
                    <a href="{{ route('admin.statistiques.visiteurs', ['periode' => $cle, 'annee' => $annee]) }}"
                        class="btn {{ $periode === $cle ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $libelle }}
                    </a>
                @endforeach
            </div>
            <form method="get" action="{{ route('admin.statistiques.visiteurs') }}" class="d-inline-flex align-items-center mb-0">
                <input type="hidden" name="periode" value="{{ $periode }}">
                <label for="annee" class="text-muted small mb-0 mr-1">Année :</label>
                <select name="annee" id="annee" class="form-control form-control-sm d-inline-block" style="width:auto" onchange="this.form.submit()">
                    @foreach($annees as $an)
                        <option value="{{ $an }}" @selected((int) $an === (int) $annee)>{{ $an }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- Cartes de synthèse --}}
    <div class="row">
        @php
            $cartes = [
                ['libelle' => 'Pages vues',       'valeur' => (int) $synthese->vues,       'icone' => 'fa-eye',           'couleur' => 'info'],
                ['libelle' => 'Visiteurs uniques', 'valeur' => (int) $synthese->visiteurs, 'icone' => 'fa-users',         'couleur' => 'success'],
                ['libelle' => 'Pages visitées',    'valeur' => (int) $synthese->pages,     'icone' => 'fa-file-alt',      'couleur' => 'warning'],
                ['libelle' => 'Lieux distincts',   'valeur' => $nbLieux,                    'icone' => 'fa-map-marker-alt', 'couleur' => 'primary'],
            ];
        @endphp
        @foreach($cartes as $carte)
            <div class="col-lg-3 col-md-6 col-12 mb-3">
                <div class="small-box bg-{{ $carte['couleur'] }}">
                    <div class="inner">
                        <h3>{{ number_format($carte['valeur'], 0, ',', ' ') }}</h3>
                        <p>{{ $carte['libelle'] }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas {{ $carte['icone'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Graphe --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>{{ $titres[$periode] }}{{ (int) $annee !== (int) now()->year ? ' — ' . $annee : '' }}</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="visitesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top 10 des pages les plus visitées --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy mr-2"></i>Top 10 des pages les plus visitées</h3>
                </div>
                <div class="card-body">
                    @php
                        $largeurMax = $topPages->isNotEmpty() ? (int) $topPages->first()->vues : 0;
                    @endphp
                    @forelse($topPages as $index => $page)
                        @php
                            $largeur = $largeurMax > 0 ? (int) round($page->vues * 100 / $largeurMax) : 0;
                            $top3 = $index < 3;
                        @endphp
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-{{ $top3 ? 'danger' : 'secondary' }} mr-2" style="min-width: 2.1rem; font-size: 1rem;">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-grow-1 mr-3">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <code class="mr-2">{{ $page->page }}</code>
                                    <span class="text-muted text-nowrap">
                                        <i class="fas fa-eye mr-1"></i>{{ number_format($page->vues, 0, ',', ' ') }} vue(s)
                                    </span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-{{ $top3 ? 'danger' : 'info' }}" style="width: {{ $largeur }}%;"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3 mb-0">Aucune visite sur la période.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Tables : pages visitées & lieux des visiteurs --}}
    <div class="row" id="tableaux-visiteurs">
        <div class="col-md-6">
            <div class="card card-outline card-secondary h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Pages visitées</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th class="text-center">Vues</th>
                                <th class="text-center">Visiteurs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td><code>{{ $page->page }}</code></td>
                                    <td class="text-center">{{ number_format($page->vues, 0, ',', ' ') }}</td>
                                    <td class="text-center">{{ number_format($page->visiteurs, 0, ',', ' ') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Aucune visite sur la période.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center py-2">
                    <small class="text-muted">{{ $pages->total() }} page(s) · 5 par page</small>
                    {{ $pages->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-secondary h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Lieux des visiteurs</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                {{-- <th>Ville</th> --}}
                                <th>Pays</th>
                                <th class="text-center">Visiteurs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lieux as $lieu)
                                <tr>
                                    {{-- <td>
                                        @if($lieu->ville !== '—')
                                            <i class="fas fa-city mr-1 text-muted"></i>
                                        @endif
                                        {{ $lieu->ville }}
                                    </td> --}}
                                    <td>
                                        @if($lieu->pays_code !== '—')
                                            <span class="badge badge-primary mr-1">{{ $lieu->pays_code }}</span>
                                        @endif
                                        {{ $lieu->pays }}
                                    </td>
                                    <td class="text-center">{{ number_format($lieu->visiteurs, 0, ',', ' ') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Aucune visite sur la période.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center py-2">
                    <small class="text-muted">{{ $lieux->total() }} lieu(x) · 5 par page</small>
                    {{ $lieux->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== JS ===================== --}}
    @section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var donnees = @json($graphique);
            var ctx = document.getElementById('visitesChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: donnees.labels,
                    datasets: [{
                        label: 'Pages vues',
                        data: donnees.vues,
                        backgroundColor: 'rgba(60,141,188,0.8)',
                        borderColor: 'rgba(60,141,188,1)',
                        borderWidth: 1
                    }, {
                        label: 'Visiteurs uniques',
                        data: donnees.visiteurs,
                        backgroundColor: 'rgba(40,167,69,0.8)',
                        borderColor: 'rgba(40,167,69,1)',
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

            });
    </script>
    @endsection
</x-admin>
