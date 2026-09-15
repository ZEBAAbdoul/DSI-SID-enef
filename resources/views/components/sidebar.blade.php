@php
    $isUser = auth()->check() && auth()->user()->hasRole('user');

    /*
    |--------------------------------------------------------------------------
    | Formations
    |--------------------------------------------------------------------------
    */
    $formationsActive =
        Route::is('admin.formations.*') ||
        Route::is('admin.sessions-formation.*') ||
        Route::is('admin.categories-formation.*') ||
        Route::is('admin.inscription.*');

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
    $bibliothequeActive =
        Route::is('admin.documents.*') ||
        Route::is('admin.categories-documents.*');

    /*
    |--------------------------------------------------------------------------
    | Paramètres
    |--------------------------------------------------------------------------
    */
    $parametresActive =
        Route::is('admin.user.*') ||
        Route::is('admin.parametres.*');
@endphp


<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false">


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

            <a href="#"
               class="nav-link {{ $formationsActive ? 'active' : '' }}">

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

            <li class="nav-item">

                <a href="#"
                   class="nav-link">

                    <i class="nav-icon fas fa-newspaper"></i>

                    <p>
                        Actualités
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-plus-circle nav-icon"></i>

                            <p>
                                Nouvelle actualité
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des actualités
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- FILIÈRES                                             --}}
            {{-- ===================================================== --}}

            <li class="nav-item">

                <a href="#"
                   class="nav-link">

                    <i class="nav-icon fas fa-sitemap"></i>

                    <p>
                        Filières
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-plus-circle nav-icon"></i>

                            <p>
                                Nouvelle filière
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

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

            <li class="nav-item">

                <a href="#"
                   class="nav-link">

                    <i class="nav-icon fas fa-chalkboard-teacher"></i>

                    <p>
                        Enseignants
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des enseignants
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-clipboard-list nav-icon"></i>

                            <p>
                                Saisie des notes
                            </p>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- ===================================================== --}}
            {{-- CANDIDATURES                                         --}}
            {{-- ===================================================== --}}

            <li class="nav-item {{ $candidaturesActive ? 'menu-open' : '' }}">

                <a href="#"
                   class="nav-link {{ $candidaturesActive ? 'active' : '' }}">

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

                <a href="#"
                   class="nav-link {{ $bibliothequeActive ? 'active' : '' }}">

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

                <a href="#"
                   class="nav-link">

                    <i class="nav-icon fas fa-images"></i>

                    <p>
                        Galeries
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>


                <ul class="nav nav-treeview">


                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

                            <i class="fas fa-camera nav-icon"></i>

                            <p>
                                Photos
                            </p>

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href=""
                           class="nav-link">

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

                <a href=""
                   class="nav-link">

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

                <a href="#"
                   class="nav-link {{ $parametresActive ? 'active' : '' }}">

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

                    {{-- Catégories --}}
                <li class="nav-item">

                    <a href="{{ route('admin.categories-formation.index') }}"
                       class="nav-link {{ Route::is('admin.categories-formation.*') ? 'active' : '' }}">

                        <i class="fas fa-tags nav-icon"></i>

                        <p>
                            Catégories de formation
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