@auth
@php
    $user = Auth::user()->loadMissing(['roles', 'personne']);
    $fullName = $user->personne?->nom_complet ?: $user->email;
    $displayName = $user->personne?->prenom ?: $user->email;
    $roles = $user->roles->pluck('name')->map(fn ($r) => ucfirst($r))->join(', ');
    $avatar = $user->avatar ?: asset('admin/dist/img/icon-user.png');

    $afficherCloche = $afficherCloche ?? false;
    $inscriptionsEnCoursCount = $inscriptionsEnCoursCount ?? 0;
    $inscriptionsEnCours = $inscriptionsEnCours ?? collect();
@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Liens de gauche -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Afficher/masquer le menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </a>
        </li>
    </ul>

    <!-- Liens de droite -->
    <ul class="navbar-nav ml-auto">

        <!-- Cloche : inscriptions en cours -->
        @if ($afficherCloche)
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button"
                   aria-label="Inscriptions en cours">
                    <i class="far fa-bell" aria-hidden="true"></i>
                    @if ($inscriptionsEnCoursCount > 0)
                        <span class="badge badge-warning navbar-badge">
                            {{ $inscriptionsEnCoursCount > 99 ? '99+' : $inscriptionsEnCoursCount }}
                        </span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        {{ $inscriptionsEnCoursCount }}
                        inscription{{ $inscriptionsEnCoursCount > 1 ? 's' : '' }} en cours
                    </span>

                    @forelse ($inscriptionsEnCours as $inscription)
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.inscriptions.show', $inscription) }}" class="dropdown-item">
                            <i class="fas fa-file-alt mr-2 text-warning" aria-hidden="true"></i>
                            <span class="font-weight-bold">
                                {{ $inscription->candidat->name ?? '' }} {{ $inscription->candidat->forname ?? '' }}
                            </span>
                            <span class="d-block small text-muted text-truncate">
                                {{ $inscription->numero_dossier }} · {{ $inscription->formation->intitule ?? '—' }}
                            </span>
                            <span class="d-block text-muted text-sm">
                                {{ $inscription->date_soumission?->diffForHumans() }}
                            </span>
                        </a>
                    @empty
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-item text-muted text-center">Aucune inscription en cours</span>
                    @endforelse

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.inscriptions.index', ['statut' => 'en_cours']) }}"
                       class="dropdown-item dropdown-footer">Voir toutes les inscriptions</a>
                </div>
            </li>
        @endif

        <!-- Menu utilisateur -->
        <li class="nav-item dropdown user-menu">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ $avatar }}" alt="Avatar de {{ $user->username }}"
                     class="img-circle elevation-1 mr-lg-2" width="30" height="30" style="object-fit: cover;">
                <span class="d-none d-lg-inline">{{ $user->username }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                <!-- En-tête utilisateur -->
                {{-- <div class="dropdown-header text-center py-3">
                    <img class="img-circle elevation-2 mb-2" src="{{ $avatar }}"
                         alt="" width="60" height="60" style="object-fit: cover;">
                    <p class="mb-0 font-weight-bold text-body">{{ $fullName }}</p>
                    <small class="text-muted d-block">{{ $user->username }}</small>
                    @if ($roles)
                        <span class="badge badge-primary mt-1">{{ $roles }}</span>
                    @endif
                </div> --}}

                {{-- <div class="dropdown-divider"></div> --}}

                <a class="dropdown-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}"
                   href="{{ route('admin.profile.edit') }}">
                    <i class="fas fa-user fa-fw mr-2 text-muted" aria-hidden="true"></i> Mon profil
                </a>

                <a class="dropdown-item {{ request()->routeIs('admin.profile.password.edit') ? 'active' : '' }}"
                   href="{{ route('admin.profile.password.edit') }}">
                    <i class="fas fa-key fa-fw mr-2 text-muted" aria-hidden="true"></i> Modifier le mot de passe
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt fa-fw mr-2" aria-hidden="true"></i> Déconnexion
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
@endauth