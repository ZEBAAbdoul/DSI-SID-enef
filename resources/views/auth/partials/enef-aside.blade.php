{{-- resources/views/auth/partials/enef-aside.blade.php --}}
{{-- Panneau institutionnel commun aux pages d'authentification --}}
{{-- ===================== PANNEAU INSTITUTIONNEL ===================== --}}
<aside class="enef-aside">
    <i class="fas fa-tree enef-tree" aria-hidden="true"></i>

    <div class="enef-aside-content">
        <a href="{{ url('/') }}" class="enef-brand" aria-label="Retour à l'accueil de l'ENEF">
            <span class="enef-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo de l'ENEF">
            </span>
            <span class="enef-brand-text">
                <span class="enef-brand-name">ENEF</span>
                <span class="enef-brand-sub">École Nationale des Eaux et Forêts</span>
            </span>
        </a>

        <div class="enef-aside-body">
            <p class="enef-kicker">Burkina Faso</p>
            <h2 class="enef-headline">Plateforme de gestion des formations et des candidatures</h2>

            <ul class="enef-features">
                <li>
                    <i class="fas fa-folder-open" aria-hidden="true"></i>
                    <span>Déposez et suivez votre dossier de candidature</span>
                </li>
                <li>
                    <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                    <span>Consultez les formations et les sessions ouvertes</span>
                </li>
                <li>
                    <i class="fas fa-shield-alt" aria-hidden="true"></i>
                    <span>Accédez à un espace personnel sécurisé</span>
                </li>
            </ul>
        </div>
    </div>

    <p class="enef-aside-footer">
        &copy; {{ date('Y') }} ENEF — Tous droits réservés
    </p>
</aside>
