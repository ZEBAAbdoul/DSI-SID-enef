@php
    $isUser = auth()->check() && auth()->user()->hasRole('user');
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- ===================================================== --}}
        {{-- MENU POUR TOUS SAUF LE ROLE USER                     --}}
        {{-- ===================================================== --}}

        @if (!$isUser)
            {{-- Accueil --}}
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>


            {{-- Actualités --}}
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <p>
                        Actualités
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-plus-circle nav-icon"></i>
                            <p>Nouvelle actualité</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Liste des actualités</p>
                        </a>
                    </li>

                </ul>
            </li>


            {{-- Filières --}}
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
                            <p>Nouvelle filière</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Liste des filières</p>
                        </a>
                    </li>

                </ul>
            </li>
        @endif


        {{-- ===================================================== --}}
        {{-- FORMATIONS                                           --}}
        {{-- VISIBLE AUSSI POUR LE ROLE USER                     --}}
        {{-- ===================================================== --}}

        <li
            class="nav-item {{ Route::is('admin.formations.*') ||
            Route::is('admin.sessions-formation.*') ||
            Route::is('admin.inscription.*')
                ? 'menu-open'
                : '' }}">

            <a href="#"
                class="nav-link {{ Route::is('admin.formations.*') ||
                Route::is('admin.sessions-formation.*') ||
                Route::is('admin.inscription.*')
                    ? 'active'
                    : '' }}">

                <i class="nav-icon fas fa-book-open"></i>

                <p>
                    Formations
                    <i class="fas fa-angle-left right"></i>
                </p>

            </a>

            <ul class="nav nav-treeview">

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
                <li class="nav-item">

                    <a href="{{ route('admin.inscription.create') }}"
                        class="nav-link {{ Route::is('admin.inscription.*') ? 'active' : '' }}">

                        <i class="fas fa-user-plus nav-icon"></i>

                        <p>
                            Inscriptions
                        </p>

                    </a>

                </li>

            </ul>
        </li>

        <!-- Enseignants & Notes -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                    Enseignants
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Liste des enseignants</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            <p>Saisie des notes</p>
                        </a>
                    </li>

                </ul>

            </li>


            {{-- Candidatures --}}
            <li class="nav-item">

                <a href="#" class="nav-link {{ Route::is('admin.inscriptions.*') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-user-graduate"></i>

                    <p>
                        Candidatures
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="{{ route('admin.inscriptions.index') }}"
                            class="nav-link {{ Route::is('admin.inscriptions.index') ? 'active' : '' }}">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Liste des candidats
                            </p>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="{{ route('admin.inscriptions.index', ['statut' => 'valide']) }}" class="nav-link">

                            <i class="fas fa-check-circle nav-icon"></i>

                            <p>
                                Candidats admis
                            </p>

                        </a>

                    </li>

                </ul>

            </li>


            {{-- Bibliothèque documentaire --}}
            <li class="nav-item">

                <a href="#"
                    class="nav-link {{ Route::is('admin.documents.*') || Route::is('admin.categories-documents.*') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-book"></i>

                    <p>
                        Bibliothèque
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="{{ route('admin.documents.index') }}"
                            class="nav-link {{ Route::is('admin.documents.*') ? 'active' : '' }}">

                            <i class="fas fa-list nav-icon"></i>

                            <p>
                                Documents
                            </p>

                        </a>

                    </li>

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


            {{-- Galeries --}}
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


            {{-- Statistiques --}}
            <li class="nav-item">

                <a href="" class="nav-link">

                    <i class="nav-icon fas fa-chart-bar"></i>

                    <p>
                        Statistiques
                    </p>

                </a>

            </li>


            {{-- Divers --}}
            <li class="nav-header">
                Divers
            </li>


            {{-- Paramètres --}}
            <li class="nav-item">

                <a href="#"
                    class="nav-link {{ Route::is('admin.user.*') || Route::is('admin.parametres.*') ? 'active' : '' }}">

                    <i class="nav-icon fas fa-cogs"></i>

                    <p>
                        Paramètres
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ Route::is('admin.user.*') ? 'active' : '' }}">

                            <i class="fas fa-users nav-icon"></i>

                            <p>
                                Utilisateurs
                            </p>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="{{ route('admin.parametres.index') }}"
                            class="nav-link {{ Route::is('admin.parametres.*') ? 'active' : '' }}">

                            <i class="fas fa-sliders-h nav-icon"></i>

                            <p>
                                Paramètres du site
                            </p>

                        </a>

                    </li>

                </ul>

            </li>


            {{-- Documentation --}}
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
