<?php
    $isUser = auth()->check() && auth()->user()->hasRole('user');
    $isEnseignant = auth()->check() && auth()->user()->hasRole('enseignant');

    $temoignagesActive = Route::is('admin.temoignages.*');
    $mesTemoignagesActive = Route::is('admin.mes-temoignages.*');

    $peutSoumettreIdee = auth()->check() && !auth()->user()->hasRole('dg');
    $peutVoirIdees =
        auth()->check() &&
        auth()
            ->user()
            ->hasAnyRole(['dg', 'sg', 'super-admin']);
    $ideesActive = Route::is('admin.idees.*') || Route::is('admin.idees-direction.*');

    /*
    |--------------------------------------------------------------------------
    | Formations
    |--------------------------------------------------------------------------
    */
    $formationsActive =
        Route::is('admin.formations.*') || Route::is('admin.sessions-formation.*') || Route::is('admin.inscription.*');

    /*
    |--------------------------------------------------------------------------
    | Candidatures
    |--------------------------------------------------------------------------
    */
    $candidaturesActive = Route::is('admin.inscriptions.*');

    /*
    |--------------------------------------------------------------------------
    | Bibliothèque
    |--------------------------------------------------------------------------
    */
    $bibliothequeActive = Route::is('admin.documents.*') || Route::is('admin.categories-documents.*');

    /*
    |--------------------------------------------------------------------------
    | Galeries
    |--------------------------------------------------------------------------
    */
    $galerieActive =
        Route::is('admin.photos.*') || Route::is('admin.videos.*');

    /*
    |--------------------------------------------------------------------------
    | Paramètres
    |--------------------------------------------------------------------------
    */
    $parametresActive =
        Route::is('admin.user.*') ||
        Route::is('admin.parametres.*') ||
        Route::is('admin.categories-formation.*') ||
        Route::is('admin.types-pieces.*') ||
        Route::is('admin.partenaires.*');

    /*
    |--------------------------------------------------------------------------
    | Filières
    |--------------------------------------------------------------------------
    */
    $filieresActive = Route::is('admin.filieres.*');
?>


<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        
        
        
        

        <?php if(!$isUser && !$isEnseignant): ?>
            <li class="nav-item">

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="nav-link <?php echo e(Route::is('admin.dashboard') ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-tachometer-alt"></i>

                    <p>
                        Dashboard
                    </p>

                </a>

            </li>
        <?php endif; ?>



        
        
        
        
        

        <?php if(!$isEnseignant): ?>
            <li class="nav-item <?php echo e($formationsActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($formationsActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-book-open"></i>

                    <p>
                        Formations
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.sessions-formation.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.sessions-formation.*') ? 'active' : ''); ?>">

                            <i class="fas fa-calendar-alt nav-icon"></i>

                            <p>
                                Sessions de formation
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.formations.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.formations.*') ? 'active' : ''); ?>">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des formations
                            </p>

                        </a>

                    </li>


                    
                    
                    <?php if($isUser): ?>
                        <li class="nav-item">

                            <a href="<?php echo e(route('admin.inscription.create')); ?>"
                                class="nav-link <?php echo e(Route::is('admin.inscription.*') ? 'active' : ''); ?>">

                                <i class="fas fa-user-plus nav-icon"></i>

                                <p>
                                    Inscriptions
                                </p>

                            </a>

                        </li>
                    <?php endif; ?>

                </ul>

            </li>
        <?php endif; ?>

        
        
        
        <?php if($isUser): ?>
            <li class="nav-item <?php echo e($mesTemoignagesActive ? 'menu-open' : ''); ?>">
                <a href="#" class="nav-link <?php echo e($mesTemoignagesActive ? 'active' : ''); ?>">
                    <i class="nav-icon fas fa-comment-dots"></i>
                    <p>
                        Témoignages
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.mes-temoignages.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.mes-temoignages.index') || Route::is('admin.mes-temoignages.edit') ? 'active' : ''); ?>">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Mes témoignages</p>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>



        
        
        
        
        

        <?php if(!$isUser): ?>
            <?php
                $enseignantsActive =
                    request()->routeIs('admin.enseignants.*') ||
                    request()->routeIs('admin.notes.*') ||
                    request()->routeIs('admin.enseignant.notes.*');
            ?>

            <li class="nav-item <?php echo e($enseignantsActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($enseignantsActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-chalkboard-teacher"></i>

                    <p>
                        Enseignants
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    
                    <?php if(!$isEnseignant): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.enseignants.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('admin.enseignants.index') ? 'active' : ''); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Liste des enseignants</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php if($isEnseignant): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.enseignant.notes.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('admin.enseignant.notes.index') ? 'active' : ''); ?>">
                                <i class="fas fa-folder-open nav-icon"></i>
                                <p>Mes notes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.enseignant.notes.create')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('admin.enseignant.notes.create') ? 'active' : ''); ?>">
                                <i class="fas fa-upload nav-icon"></i>
                                <p>Déposer un fichier</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php if(!$isEnseignant): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.notes.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('admin.notes.index') ? 'active' : ''); ?>">
                                <i class="fas fa-file-download nav-icon"></i>
                                <p>Consultation des notes</p>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>

            </li>
        <?php endif; ?>

        
        
        
        
        
        <?php if($peutSoumettreIdee || $peutVoirIdees): ?>
            <?php
                $ideesEnAttente = $peutVoirIdees ? \App\Models\Idee::where('statut', 'soumise')->count() : 0;
            ?>

            <li class="nav-item <?php echo e($ideesActive ? 'menu-open' : ''); ?>">
                <a href="#" class="nav-link <?php echo e($ideesActive ? 'active' : ''); ?>">
                    <i class="nav-icon fas fa-lightbulb"></i>
                    <p>
                        Boîte à idées
                        <?php if($ideesEnAttente > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($ideesEnAttente); ?></span>
                        <?php else: ?>
                            <i class="fas fa-angle-left right"></i>
                        <?php endif; ?>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <?php if($peutSoumettreIdee): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.idees.create')); ?>"
                                class="nav-link <?php echo e(Route::is('admin.idees.create') ? 'active' : ''); ?>">
                                <i class="fas fa-pen nav-icon"></i>
                                <p>Proposer une idée</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.idees.index')); ?>"
                                class="nav-link <?php echo e(Route::is('admin.idees.index') || Route::is('admin.idees.edit') ? 'active' : ''); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Mes idées</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($peutVoirIdees): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.idees-direction.index')); ?>"
                                class="nav-link <?php echo e(Route::is('admin.idees-direction.*') ? 'active' : ''); ?>">
                                <i class="fas fa-inbox nav-icon"></i>
                                <p>
                                    Toutes les idées
                                    <?php if($ideesEnAttente > 0): ?>
                                        <span class="badge badge-warning right"><?php echo e($ideesEnAttente); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>



        
        
        
        

        <?php if(!$isUser && !$isEnseignant): ?>
            
            
            

            <li class="nav-item <?php echo e(request()->routeIs('admin.actualites.*') ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e(request()->routeIs('admin.actualites.*') ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-newspaper"></i>

                    <p>
                        Actualités
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.actualites.index')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('admin.actualites.index') ? 'active' : ''); ?>">

                            <i class="far fa-circle nav-icon"></i>

                            <p>
                                Liste des actualités
                            </p>

                        </a>
                    </li>


                    
                    

                </ul>

            </li>

            
            
            

            <li class="nav-item <?php echo e(request()->routeIs('admin.recherches-innovations.*') ? 'active' : ''); ?>">

                <a href="<?php echo e(route('admin.recherches-innovations.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('admin.recherches-innovations.*') ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-flask"></i>

                    <p>
                        Recherche & Innovation
                    </p>

                </a>

            </li>

            
            
            
            <?php $temoignagesEnAttente = \App\Models\Temoignage::where('est_publie', false)->count(); ?>

            <li class="nav-item">
                <a href="<?php echo e(route('admin.temoignages.index')); ?>"
                    class="nav-link <?php echo e($temoignagesActive ? 'active' : ''); ?>">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        Témoignages
                        <?php if($temoignagesEnAttente > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($temoignagesEnAttente); ?></span>
                        <?php endif; ?>
                    </p>
                </a>
            </li>



            
            
            

            <li class="nav-item <?php echo e($filieresActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($filieresActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-sitemap"></i>

                    <p>
                        Filières
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.filieres.create')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.filieres.create') ? 'active' : ''); ?>">

                            <i class="fas fa-plus-circle nav-icon"></i>

                            <p>
                                Nouvelle filière
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.filieres.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.filieres.index') || Route::is('admin.filieres.edit') ? 'active' : ''); ?>">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des filières
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            
            
            

            <li class="nav-item <?php echo e($candidaturesActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($candidaturesActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-user-graduate"></i>

                    <p>
                        Candidatures
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.inscriptions.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.inscriptions.index') && !request('statut') ? 'active' : ''); ?>">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des candidats
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.inscriptions.index', ['statut' => 'valide'])); ?>"
                            class="nav-link <?php echo e(request('statut') === 'valide' ? 'active' : ''); ?>">

                            <i class="fas fa-check-circle nav-icon"></i>

                            <p>
                                Candidats admis
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            
            
            

            <li class="nav-item <?php echo e($bibliothequeActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($bibliothequeActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-book"></i>

                    <p>
                        Bibliothèque
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.documents.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.documents.*') ? 'active' : ''); ?>">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Documents
                            </p>

                        </a>

                    </li>


                    
                    

                </ul>

            </li>



            
            
            


            <li class="nav-item <?php echo e($galerieActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($galerieActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-images"></i>

                    <p>
                        Galeries
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.photos.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.photos.*') ? 'active' : ''); ?>">

                            <i class="fas fa-camera nav-icon"></i>

                            <p>
                                Photos
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.videos.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.videos.*') ? 'active' : ''); ?>">

                            <i class="fas fa-video nav-icon"></i>

                            <p>
                                Vidéos
                            </p>

                        </a>

                    </li>

                </ul>

            </li>





            
            
            

            <li class="nav-item">

                <a href="" class="nav-link">

                    <i class="nav-icon fas fa-chart-bar"></i>

                    <p>
                        Statistiques
                    </p>

                </a>

            </li>



            
            
            

            <li class="nav-header">
                Divers
            </li>



            
            
            

            <li class="nav-item <?php echo e($parametresActive ? 'menu-open' : ''); ?>">

                <a href="#" class="nav-link <?php echo e($parametresActive ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-cogs"></i>

                    <p>
                        Paramètres
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.user.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.user.*') ? 'active' : ''); ?>">

                            <i class="fas fa-users nav-icon"></i>

                            <p>
                                Utilisateurs
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.parametres.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.parametres.*') ? 'active' : ''); ?>">

                            <i class="fas fa-sliders-h nav-icon"></i>

                            <p>
                                Paramètres du site
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.categories-formation.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.categories-formation.*') ? 'active' : ''); ?>">

                            <i class="fas fa-tags nav-icon"></i>

                            <p>
                                Catégories de formation
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.formation-informations.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.formation-informations.*') ? 'active' : ''); ?>">

                            <i class="fas fa-info-circle nav-icon"></i>

                            <p>
                                Informations formations
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.categories-documents.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.categories-documents.*') ? 'active' : ''); ?>">

                            <i class="fas fa-tags nav-icon"></i>

                            <p>
                                Catégories de documents
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.types-pieces.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.types-pieces.*') ? 'active' : ''); ?>">

                            <i class="fas fa-id-card nav-icon"></i>

                            <p>
                                Types de pièces
                            </p>

                        </a>

                    </li>


                    
                    <li class="nav-item">

                        <a href="<?php echo e(route('admin.partenaires.index')); ?>"
                            class="nav-link <?php echo e(Route::is('admin.partenaires.*') ? 'active' : ''); ?>">

                            <i class="fas fa-handshake nav-icon"></i>

                            <p>
                                Partenaires
                            </p>

                        </a>

                    </li>


                </ul>

            </li>



            
            
            
            

            <li class="nav-item">

                <a href="<?php echo e(route('manual.index')); ?>"
                    class="nav-link <?php echo e(Route::is('manual.index') ? 'active' : ''); ?>">

                    <i class="nav-icon fas fa-book-journal-whills"></i>

                    <p>
                        Documentation
                    </p>

                </a>

            </li>
        <?php endif; ?>

    </ul>

</nav>
<?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/components/sidebar.blade.php ENDPATH**/ ?>