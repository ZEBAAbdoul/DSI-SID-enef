@php
    $isUser = auth()->check() && auth()->user()->hasRole('user');

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
    | Paramètres
    |--------------------------------------------------------------------------
    */
    $parametresActive =
        Route::is('admin.user.*') ||
        Route::is('admin.parametres.*') ||
        Route::is('admin.categories-formation.*') ||
        Route::is('admin.types-pieces.*') ||
        Route::is('admin.partenaires.*');
@endphp


<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        {{-- ========================================================= --}}
        {{-- ACCUEIL                                                  --}}
        {{-- INVISIBLE POUR LE ROLE USER                              --}}
        {{-- ========================================================= --}}

        @if (!$isUser)
            <li class="nav-item">

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-tachometer-alt"></i>

                    <p>
                        Dashboard
                    </p>

                </a>

            </li>
        @endif



        {{-- ========================================================= --}}
        {{-- FORMATIONS                                               --}}
        {{-- Accessible également au rôle USER                        --}}
        {{-- Positionné juste après le Dashboard                     --}}
        {{-- ========================================================= --}}

        <li class="nav-item {{ $formationsActive ? 'menu-open' : '' }}">

            <a href="#" class="nav-link {{ $formationsActive ? 'active' : '' }}">

                <i class="nav-icon fas fa-book-open"></i>

                <p>
                    Formations
                    <i class="fas fa-angle-left right"></i>
                </p>

            </a>


            <ul class="nav nav-treeview">


                {{-- Sessions --}}
                <li class="nav-item">

                    <a href="{{ route('admin.sessions-formation.index') }}"
                        class="nav-link {{ Route::is('admin.sessions-formation.*') ? 'active' : '' }}">

                        <i class="fas fa-calendar-alt nav-icon"></i>

                        <p>
                            Sessions de formation
                        </p>

                    </a>

                </li>


                {{-- Liste des formations --}}
                <li class="nav-item">

                    <a href="{{ route('admin.formations.index') }}"
                        class="nav-link {{ Route::is('admin.formations.*') ? 'active' : '' }}">

                        <i class="fas fa-list nav-icon"></i>

                        <p>
                            Liste des formations
                        </p>

                    </a>

                </li>


                {{-- Inscriptions --}}
                {{-- Visible uniquement pour le rôle USER --}}
                @if ($isUser)
                    <li class="nav-item">

                        <a href="{{ route('admin.inscription.create') }}"
                            class="nav-link {{ Route::is('admin.inscription.*') ? 'active' : '' }}">

                            <i class="fas fa-user-plus nav-icon"></i>

                            <p>
                                Inscriptions
                            </p>

                        </a>

                    </li>
                @endif

            </ul>

        </li>



        {{-- ========================================================= --}}
        {{-- TOUT LE RESTE DU MENU                                    --}}
        {{-- INVISIBLE POUR LE ROLE USER                              --}}
        {{-- ========================================================= --}}

        @if (!$isUser)
            {{-- ===================================================== --}}
            {{-- ACTUALITÉS                                           --}}
            {{-- ===================================================== --}}

            <li class="nav-item {{ request()->routeIs('admin.actualites.*') ? 'menu-open' : '' }}">

                <a href="#" class="nav-link {{ request()->routeIs('admin.actualites.*') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-newspaper"></i>

                    <p>
                        Actualités
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    {{-- Liste des actualités --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.actualites.index') }}"
                            class="nav-link {{ request()->routeIs('admin.actualites.index') ? 'active' : '' }}">

                            <i class="far fa-circle nav-icon"></i>

                            <p>
                                Liste des actualités
                            </p>

                        </a>
                    </li>


                    {{-- Ajouter une actualité --}}
                    {{-- <li class="nav-item">
            <a href="{{ route('admin.actualites.create') }}"
               class="nav-link {{ request()->routeIs('admin.actualites.create') ? 'active' : '' }}">

                <i class="far fa-circle nav-icon"></i>

                <p>
                    Ajouter une actualité
                </p>

            </a>
        </li> --}}

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- FILIÈRES                                             --}}
            {{-- ===================================================== --}}

            <li class="nav-item">

                <a href="#" class="nav-link">

                    <i class="nav-icon fas fa-sitemap"></i>

                    <p>
                        Filières
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="" class="nav-link">

                            <i class="fas fa-plus-circle nav-icon"></i>

                            <p>
                                Nouvelle filière
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="" class="nav-link">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des filières
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
{{-- ENSEIGNANTS & NOTES                                  --}}
{{-- ===================================================== --}}

@php
    $enseignantsActive = request()->routeIs('admin.enseignants.*') || request()->routeIs('admin.notes.*') || request()->routeIs('admin.enseignant.notes.*');
@endphp

<li class="nav-item {{ $enseignantsActive ? 'menu-open' : '' }}">

    <a href="#" class="nav-link {{ $enseignantsActive ? 'active' : '' }}">

        <i class="nav-icon fas fa-chalkboard-teacher"></i>

        <p>
            Enseignants
            <i class="fas fa-angle-left right"></i>
        </p>

    </a>


    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{ route('admin.enseignants.index') }}"
                class="nav-link {{ request()->routeIs('admin.enseignants.index') ? 'active' : '' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>Liste des enseignants</p>
            </a>
        </li>

        {{-- Visible pour l'enseignant : dépôt de ses fichiers --}}
        @if (auth()->user()->hasRole('enseignant'))
            <li class="nav-item">
                <a href="{{ route('admin.enseignant.notes.index') }}"
                    class="nav-link {{ request()->routeIs('admin.enseignant.notes.index') ? 'active' : '' }}">
                    <i class="fas fa-folder-open nav-icon"></i>
                    <p>Mes notes</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.enseignant.notes.create') }}"
                    class="nav-link {{ request()->routeIs('admin.enseignant.notes.create') ? 'active' : '' }}">
                    <i class="fas fa-upload nav-icon"></i>
                    <p>Déposer un fichier</p>
                </a>
            </li>
        @endif

        {{-- Visible pour l'admin/gérant : consultation --}}
        @if (!auth()->user()->hasRole('enseignant'))
            <li class="nav-item">
                <a href="{{ route('admin.notes.index') }}"
                    class="nav-link {{ request()->routeIs('admin.notes.index') ? 'active' : '' }}">
                    <i class="fas fa-file-download nav-icon"></i>
                    <p>Consultation des notes</p>
                </a>
            </li>
        @endif

    </ul>

</li>



            {{-- ===================================================== --}}
            {{-- CANDIDATURES                                         --}}
            {{-- ===================================================== --}}

            <li class="nav-item {{ $candidaturesActive ? 'menu-open' : '' }}">

                <a href="#" class="nav-link {{ $candidaturesActive ? 'active' : '' }}">

                    <i class="nav-icon fas fa-user-graduate"></i>

                    <p>
                        Candidatures
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    {{-- Liste des candidats --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.inscriptions.index') }}"
                            class="nav-link {{ Route::is('admin.inscriptions.index') && !request('statut') ? 'active' : '' }}">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des candidats
                            </p>

                        </a>

                    </li>


                    {{-- Candidats admis --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.inscriptions.index', ['statut' => 'valide']) }}"
                            class="nav-link {{ request('statut') === 'valide' ? 'active' : '' }}">

                            <i class="fas fa-check-circle nav-icon"></i>

                            <p>
                                Candidats admis
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- BIBLIOTHÈQUE                                         --}}
            {{-- ===================================================== --}}

            <li class="nav-item {{ $bibliothequeActive ? 'menu-open' : '' }}">

                <a href="#" class="nav-link {{ $bibliothequeActive ? 'active' : '' }}">

                    <i class="nav-icon fas fa-book"></i>

                    <p>
                        Bibliothèque
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    {{-- Documents --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.documents.index') }}"
                            class="nav-link {{ Route::is('admin.documents.*') ? 'active' : '' }}">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Documents
                            </p>

                        </a>

                    </li>


                    {{-- Catégories --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.categories-documents.index') }}"
                            class="nav-link {{ Route::is('admin.categories-documents.*') ? 'active' : '' }}">

                            <i class="fas fa-tags nav-icon"></i>

                            <p>
                                Catégories
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- GALERIES                                             --}}
            {{-- ===================================================== --}}

            <li class="nav-item">

                <a href="#" class="nav-link">

                    <i class="nav-icon fas fa-images"></i>

                    <p>
                        Galeries
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    <li class="nav-item">

                        <a href="" class="nav-link">

                            <i class="fas fa-camera nav-icon"></i>

                            <p>
                                Photos
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="" class="nav-link">

                            <i class="fas fa-video nav-icon"></i>

                            <p>
                                Vidéos
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- STATISTIQUES                                         --}}
            {{-- ===================================================== --}}

            <li class="nav-item">

                <a href="" class="nav-link">

                    <i class="nav-icon fas fa-chart-bar"></i>

                    <p>
                        Statistiques
                    </p>

                </a>

            </li>



            {{-- ===================================================== --}}
            {{-- DIVERS                                               --}}
            {{-- ===================================================== --}}

            <li class="nav-header">
                Divers
            </li>



            {{-- ===================================================== --}}
            {{-- PARAMÈTRES                                            --}}
            {{-- ===================================================== --}}

            <li class="nav-item {{ $parametresActive ? 'menu-open' : '' }}">

                <a href="#" class="nav-link {{ $parametresActive ? 'active' : '' }}">

                    <i class="nav-icon fas fa-cogs"></i>

                    <p>
                        Paramètres
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    {{-- Utilisateurs --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ Route::is('admin.user.*') ? 'active' : '' }}">

                            <i class="fas fa-users nav-icon"></i>

                            <p>
                                Utilisateurs
                            </p>

                        </a>

                    </li>


                    {{-- Paramètres du site --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.parametres.index') }}"
                            class="nav-link {{ Route::is('admin.parametres.*') ? 'active' : '' }}">

                            <i class="fas fa-sliders-h nav-icon"></i>

                            <p>
                                Paramètres du site
                            </p>

                        </a>

                    </li>


                    {{-- Catégories de formation --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.categories-formation.index') }}"
                            class="nav-link {{ Route::is('admin.categories-formation.*') ? 'active' : '' }}">

                            <i class="fas fa-tags nav-icon"></i>

                            <p>
                                Catégories de formation
                            </p>

                        </a>

                    </li>


                    {{-- Types de pièces --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.types-pieces.index') }}"
                            class="nav-link {{ Route::is('admin.types-pieces.*') ? 'active' : '' }}">

                            <i class="fas fa-id-card nav-icon"></i>

                            <p>
                                Types de pièces
                            </p>

                        </a>

                    </li>


                    {{-- Partenaires --}}
                    <li class="nav-item">

                        <a href="{{ route('admin.partenaires.index') }}"
                            class="nav-link {{ Route::is('admin.partenaires.*') ? 'active' : '' }}">

                            <i class="fas fa-handshake nav-icon"></i>

                            <p>
                                Partenaires
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- DOCUMENTATION                                        --}}
            {{-- ===================================================== --}}

            <li class="nav-item">

                <a href="{{ route('manual.index') }}"
                    class="nav-link {{ Route::is('manual.index') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-book-journal-whills"></i>

                    <p>
                        Documentation
                    </p>

                </a>

            </li>
        @endif

    </ul>

</nav>
