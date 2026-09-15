<div class="content">

    <!-- Boîtes de statistiques -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['candidatures_total'] ?? 0 }}</h3>
                    <p>Candidatures reçues</p>
                </div>
                <div class="icon"><i class="fa fa-user-graduate"></i></div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">Voir <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['formations_ouvertes'] ?? 0 }}</h3>
                    <p>Formations ouvertes</p>
                </div>
                <div class="icon"><i class="fas fa-book-open"></i></div>
                <a href="#" class="small-box-footer">Voir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['sessions_a_venir'] ?? 0 }}</h3>
                    <p>Sessions à venir ({{ $stats['places_disponibles'] ?? 0 }} places dispo.)</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <a href="#" class="small-box-footer">Voir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['documents_publies'] ?? 0 }}</h3>
                    <p>Documents publiés</p>
                </div>
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <a href="{{ route('bibliotheque.index') }}" class="small-box-footer">Voir <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <br>
    <div class="container-fluid">
        <div class="row">
            <!-- Prochaines sessions -->
            <div class="col-md-8">
                <div class="card card-secondary">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Prochaines sessions de formation</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>FORMATION</th>
                                        <th>LIEU</th>
                                        <th>DATE DE DÉBUT</th>
                                        <th>PLACES</th>
                                        <th>STATUT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($prochainesSessions as $session)
                                        <tr>
                                            <td>{{ $session->formation->titre ?? 'Formation supprimée' }}</td>
                                            <td>{{ $session->lieu ?? '—' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                                            </td>
                                            <td>{{ $session->places_disponibles }} / {{ $session->places_totales }}
                                            </td>
                                            <td><span class="badge bg-success">{{ ucfirst($session->statut) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucune session à venir.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="#" class="btn btn-sm btn-secondary float-right">Voir tout</a>
                    </div>
                </div>

                <!-- Graphique des inscriptions mensuelles -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Inscriptions par mois (6 derniers mois)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="height: 250px; min-height: 250px"></canvas>
                    </div>
                </div>
            </div>

            <!-- Formations les plus demandées -->
            <div class="col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Formations les plus demandées</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>FORMATION</th>
                                    <th>SESSIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($formationsPopulaires as $formation)
                                    <tr>
                                        <td>{{ $formation->titre }}</td>
                                        <td>{{ $formation->sessions_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Aucune formation.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="uppercase">Voir toutes les formations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('admin.dashboard.chart-data') }}')
                .then(response => response.json())
                .then(data => {
                    var ctx = document.getElementById('barChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Inscriptions',
                                data: data.values,
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endpush