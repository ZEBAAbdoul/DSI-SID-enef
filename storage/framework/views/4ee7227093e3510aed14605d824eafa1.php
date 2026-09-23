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
                                    <?php $__currentLoopData = $latestSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($sale->product->name ?? 'Produit non trouvé'); ?></td>
                                            <td><?php echo e($sale->quantity); ?></td>
                                            <td><?php echo e($sale->unit_price); ?> f cfa</td>
                                            <td><?php echo e($sale->total_amount); ?> f cfa</td>
                                            <td><?php echo e($sale->created_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <!-- Boutons pour ajouter une nouvelle commande et voir toutes les commandes -->
                        <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-sm btn-info float-left">Nouvelle
                            Vente</a>
                        <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-sm btn-secondary float-right">Voir tout</a>
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
                        <?php if($topProducts->isEmpty()): ?>
                            <p>Aucun produit vendu.</p>
                        <?php else: ?>
                            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th>PRODUIT</th>
                                        <th>QUANTITÉ</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="col-md-4">
                                                    <!-- Affichage de la photo du produit -->
                                                    <?php if($product->product->photo_path): ?>
                                                        <img src="<?php echo e(asset('storage/' . $product->product->photo_path)); ?>"
                                                            alt="Photo du produit" width="77" height="77">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('images/default.jpg')); ?>"
                                                            alt="Image par défaut" class="img-fluid">
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo e($product->product->name ?? 'Produit non trouvé'); ?></td>
                                            <td><?php echo e($product->total_sold); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-center">
                        <!-- Bouton pour voir tous les produits -->
                        <a href="<?php echo e(route('products.index')); ?>" class="uppercase">Voir Tous les Produits</a>
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
                labels: <?php echo json_encode($salesByMonth['labels'], 15, 512) ?>,
                datasets: [{
                    label: 'Ventes mensuelles',
                    data: <?php echo json_encode($salesByMonth['values'], 15, 512) ?>,
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
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\components\cardListe.blade.php ENDPATH**/ ?>