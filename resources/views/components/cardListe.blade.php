<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Les 10 dernières ventes -->
            <div class="col-md-8">
                <!-- Card pour les dernières ventes -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Les 10 dernières ventes</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Tableau des dernières ventes -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>PRODUIT</th>
                                        <th>QTÉ</th>
                                        <th>PRIX UNITAIRE</th>
                                        <th>MONTANT TOTAL</th>
                                        <th>DATE DE VENTE</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($latestSales as $sale)
                                        <tr>
                                            <td>{{ $sale->product->name ?? 'Produit non trouvé' }}</td>
                                            <td>{{ $sale->quantity }}</td>
                                            <td>{{ $sale->unit_price }} f cfa</td>
                                            <td>{{ $sale->total_amount }} f cfa</td>
                                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <!-- Boutons pour ajouter une nouvelle commande et voir toutes les commandes -->
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-info float-left">Nouvelle
                            Vente</a>
                        <a href="{{route('sales.index')}}" class="btn btn-sm btn-secondary float-right">Voir tout</a>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Statistiques des ventes</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Canvas pour le graphique des ventes mensuelles -->
                        <canvas id="barChart" style="height: 250px; min-height: 250px"></canvas>
                    </div>
                </div>
            </div>

            <!-- 5 Produits les plus Vendus -->
            <div class="col-md-4">
                <!-- Card pour les produits les plus vendus -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">5 Produits les plus Vendus</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Tableau des produits les plus vendus -->
                        @if ($topProducts->isEmpty())
                            <p>Aucun produit vendu.</p>
                        @else
                            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th>PRODUIT</th>
                                        <th>QUANTITÉ</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($topProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="col-md-4">
                                                    <!-- Affichage de la photo du produit -->
                                                    @if ($product->product->photo_path)
                                                        <img src="{{ asset('storage/' . $product->product->photo_path) }}"
                                                            alt="Photo du produit" width="77" height="77">
                                                    @else
                                                        <img src="{{ asset('images/default.jpg') }}"
                                                            alt="Image par défaut" class="img-fluid">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $product->product->name ?? 'Produit non trouvé' }}</td>
                                            <td>{{ $product->total_sold }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <!-- Bouton pour voir tous les produits -->
                        <a href="{{ route('products.index') }}" class="uppercase">Voir Tous les Produits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($salesByMonth['labels']),
                datasets: [{
                    label: 'Ventes mensuelles',
                    data: @json($salesByMonth['values']),
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            min: 0, // Point de départ de l'axe y
                            stepSize: 10 // Intervalle entre chaque graduation
                        }
                    }
                }
            }
        });
    });
</script>
