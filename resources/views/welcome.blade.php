@extends('layouts.site')

@section('title', 'ENEF — Accueil')

@section('content')

    <!-- ===================== HERO ===================== -->
    <section class="hero" style="padding:0;">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow-line"><span class="rule"></span> École publique — Bobo-Dioulasso, Burkina
                    Faso</div>
                <h1>{{ $param_site->slogan ?? 'École Nationale des Eaux et Forêts' }}</h1>
                <p class="hero-lede">{{ $param_site->meta_description ?? '' }}</p>
                <div class="hero-ctas">
                    <a href="#admissions" class="btn btn-primary">Candidater en ligne</a>
                    {{-- <a href="{{ route('catalogue.formations.initiales') }}" class="btn btn-ghost-light">Découvrir le catalogue de
                        formations</a> --}}
                </div>
                <div class="hero-stats">
                    <div><span class="num">{{ $param_site->annee_creation ?? '—' }}</span><span class="lbl">Année
                            de création de l'école</span>
                    </div>
                    <div><span class="num">{{ $param_site->personne_forme ?? '—' }} <strong>+</strong> </span><span class="lbl">Personnes
                            formées à nos jours</span>
                    </div>
                    {{-- <div><span class="num">{{ $fillieres->count() }}</span><span class="lbl">Filières de
                            spécialisation</span></div> --}}
                </div>
            </div>
            <div class="hero-side">
                @if ($derniereActualite)
                    <img src="{{ $derniereActualite->image }}" alt="{{ $derniereActualite->titre }}"
                        class="hero-side-photo">
                    <span class="tag">Actualité à la une</span>
                    <h3>{{ $derniereActualite->titre }}</h3>
                    <p>{{ $derniereActualite->chapo ?? $derniereActualite->resume }}</p>
                    <a href="{{ route('actualites.show', $derniereActualite->slug) }}" class="btn btn-water btn-sm">Lire
                        l'actualité</a>
                @else
                    <img src="{{ asset('images/actualite1.jpg') }}" alt="Ouverture des candidatures — session 2026/2027"
                        class="hero-side-photo">
                    <span class="tag">Actualité à la une</span>
                    <h3>Ouverture des candidatures — session 2026/2027</h3>
                    <p>Les inscriptions pour le concours d'entrée en formation initiale et les sessions de formation
                        continue sont ouvertes jusqu'au 15 octobre 2026.</p>
                    <a href="#admissions" class="btn btn-water btn-sm">Voir les conditions d'accès</a>
                @endif
            </div>
        </div>
    </section>

    <!-- ===================== TÉMOIGNAGES (BANDE COMPACTE) ===================== -->
    @if ($temoignages->isNotEmpty())
        <div class="testi-marquee testi-marquee--compact" aria-label="Témoignages des élèves de l'ENEF">
            @include('partials.testimonials-track', [
                'temoignages' => $temoignages,
                'compact' => true,
            ])
        </div>
    @endif

    <!-- ===================== MOT DU DG ===================== -->
    <section id="dg">
        <div class="container dg-section">
            <div class="dg-portrait">
                @if ($param_site && $param_site->mot_dg_photo_url)
                    <img src="{{ asset($param_site->mot_dg_photo_url) }}"
                        alt="Photo du {{ $param_site->mot_dg_nom ?? 'Directeur Général' }}" class="dg-photo">
                @else
                    <img src="{{ asset('images/DG.jpg') }}" alt="Photo du Directeur Général" class="dg-photo">
                @endif

                <span class="cap">
                    <b>{{ $param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO' }}</b>
                    {{ $param_site->mot_dg_titre ?? "Directeur Général de l'ENEF" }}
                </span>
            </div>
            <div>
                <span class="section-head kicker" style="display:block;">Mot du Directeur Général</span>
                <blockquote>« {{ \Illuminate\Support\Str::limit($param_site->mot_dg_contenu ?? '', 320) }} »</blockquote>
                <div class="dg-signoff">
                    <b>{{ $param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO' }}</b>
                    Directeur Général de l'École Nationale des Eaux et Forêts
                </div>
                <div style="margin-top:24px;display:flex;gap:14px;flex-wrap:wrap;">
                    <a href="{{ route('mot-directeur') }}" class="btn btn-outline btn-sm">Lire le message intégral</a>
                    <a href="{{ route('unites-pedagogiques') }}" class="btn btn-outline btn-sm">Découvrir nos unités
                        pédagogiques</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== ACTUALITÉS ===================== -->
    <section id="actualites" class="alt">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="kicker">Actualités</span>
                    <h2>La vie de l'école, au fil des promotions</h2>
                </div>
                <a href="{{ route('actualites.index') }}" class="btn btn-outline btn-sm">Toutes les actualités</a>
            </div>
            <div class="news-slider">
                <button type="button" id="news-prev" class="news-nav-btn news-arrow news-arrow--left"
                    aria-label="Actualité précédente" title="Actualité précédente">&larr;</button>

                <div class="news-marquee" id="news-marquee" aria-label="Dernières actualités de l'ENEF">
                    <div class="news-track" id="news-track">
                        @forelse ($actualites as $actualite)
                            @include('partials.news-card', ['actualite' => $actualite])
                        @empty
                            <p style="color:var(--ink-soft);">Aucune actualité publiée pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                    {{-- Duplication du flux pour l'effet de défilement continu (CSS) --}}
                    @if ($actualites->count() > 2)
                        @foreach ($actualites as $actualite)
                            @include('partials.news-card', ['actualite' => $actualite, 'hidden' => true])
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="button" id="news-next" class="news-nav-btn news-arrow news-arrow--right"
                aria-label="Actualité suivante" title="Actualité suivante">&rarr;</button>
        </div>
    </section>

    <!-- ===================== ADMISSIONS ===================== -->
    <section id="admissions">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="kicker">Admissions</span>
                    <h2>Un parcours de candidature entièrement en ligne</h2>
                    <p class="desc">Déposez votre dossier, suivez son traitement et consultez les résultats
                        directement depuis votre espace personnel.</p>
                </div>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <h4>Créer son compte candidat</h4>
                    <p>Inscrivez-vous en quelques minutes pour accéder à l'espace de candidature.</p>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <h4>Déposer son dossier</h4>
                    <p>Formulaire de préinscription et dépôt des pièces justificatives dématérialisé.</p>
                    <span class="status">Statut : déposé</span>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <h4>Suivre son dossier</h4>
                    <p>Notification par e-mail à chaque étape : en cours, incomplet, validé.</p>
                    <span class="status">Statut : en cours</span>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <h4>Consulter les résultats</h4>
                    <p>Liste des admis consultable en ligne, recherche par nom ou numéro de dossier.</p>
                </div>
            </div>
            <div class="admissions-cta">
                <div>
                    <h3>Prêt à rejoindre l'ENEF ?</h3>
                    <p>Les candidatures pour la session 2026/2027 sont ouvertes jusqu'au 15 octobre 2026.</p>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="{{ route('inscription') }}" class="btn btn-primary">Postuler maintenant</a>
                    {{-- <a href="#suivi" class="btn btn-ghost-light">Suivre mon dossier</a> --}}
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== CATALOGUE FORMATIONS ===================== -->
    {{-- Bloc commenté : à réactiver si nécessaire --}}
    {{--
    À COLLER dans resources/views/.../accueil.blade.php
    en remplaçant TOUT le bloc <section id="catalogue" class="alt"> ... </section> existant.

    Puis, dans le @push('scripts'), remplacer une seule ligne :
        var activeGroup = 'programmee';
    par :
        var activeGroup = 'initiale';
--}}

    <!-- ===================== CATALOGUE FORMATIONS ===================== -->
    {{-- <section id="catalogue" class="alt">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="kicker">Formations</span>
                    <h2>Catalogue de formations initiales et continues</h2>
                    <p class="desc">Cycles de formation initiale (Eaux et Forêts, Environnement), formations
                        programmées à dates fixes ou modules à la carte, conçus pour les professionnels de
                        l'environnement et des ressources naturelles.</p>
                </div>
            </div>

            <div class="tabs" role="tablist">
                <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="initiale">Formations
                    initiales</button>
                <button class="tab-btn" role="tab" aria-selected="false" data-filter-group="programmee">Formations
                    programmées</button>
                <button class="tab-btn" role="tab" aria-selected="false" data-filter-group="carte">Formations à la
                    carte</button>
            </div>



            <div class="courses-grid">
                @forelse ($formation as $item)
                    @php
                        $groupe = match ($item->type) {
                            'continue_a_la_carte' => 'carte',
                            'continue_programmee' => 'programmee',
                            default => 'initiale',
                        };
                        $estALaCarte = $groupe === 'carte';
                        $estInitiale = $groupe === 'initiale';
                    @endphp
                    <div class="course-card" data-group="{{ $groupe }}" data-cat="{{ $item->categorie_id }}">
                        <div class="course-top">
                            @if ($estALaCarte)
                                <span class="badge carte">À la carte</span>
                            @elseif ($estInitiale)
                                <span class="badge prog">Formation initiale</span>
                            @else
                                <span class="badge prog">{{ $item->type_libelle }}</span>
                            @endif
                        </div>
                        <h4>{{ $item->titre }}</h4>
                        <p class="d">{{ $item->resume }}</p>
                        <div class="course-meta">
                            <span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 3" />
                                </svg>
                                {{ $item->duree_formate }}
                            </span>
                            @if ($estInitiale)
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                    </svg>
                                    {{ $item->cout_indicatif ? number_format($item->cout_indicatif, 0, ',', ' ') . ' F CFA / an' : 'Frais : nous consulter' }}
                                </span>
                            @else
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                    {{ $item->public_cible ?? 'Tous publics' }}
                                </span>
                            @endif
                        </div>

                        @if (!$estALaCarte && !$estInitiale && $item->sessions->isNotEmpty())
                            <div class="sessions-block">
                                <span class="sessions-title">Prochaines sessions</span>
                                <ul class="sessions-list">
                                    @foreach ($item->sessions->take(3) as $session)
                                        <li class="session-item">
                                            <span class="session-date">
                                                {{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                                                @if ($session->date_fin)
                                                    →
                                                    {{ \Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y') }}
                                                @endif
                                            </span>
                                            <span class="session-lieu">{{ $session->lieu }}</span>
                                            <span class="session-places">
                                                {{ $session->places_disponibles }} place(s) disponible(s)
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($estALaCarte)
                        @else
                            <a href="{{ route('formations.show', $item->slug) }}" class="btn btn-outline btn-sm">
                                {{ $estInitiale ? 'Voir la fiche du cycle' : 'Voir la fiche du module' }}
                            </a>
                        @endif
                    </div>
                @empty
                    <p style="color:var(--ink-soft);">Aucune formation disponible pour le moment.</p>
                @endforelse
            </div>

        </div>
    </section> --}}

    <!-- ===================== SESSIONS À VENIR ===================== -->
    @if ($sessions->isNotEmpty())
        <section id="sessions" class="alt">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="kicker">Agenda</span>
                        <h2>Prochaines sessions de formation</h2>
                        <p class="desc">Calendrier des sessions ouvertes — inscrivez-vous avant la clôture des
                            inscriptions.</p>
                    </div>
                </div>
                <div class="sessions-agenda">
                    @foreach ($sessions as $session)
                        <div class="agenda-card">
                            <div class="agenda-date">
                                <span class="day">{{ \Carbon\Carbon::parse($session->date_debut)->format('d') }}</span>
                                <span
                                    class="month">{{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('M') }}</span>
                                <span class="year">{{ \Carbon\Carbon::parse($session->date_debut)->format('Y') }}</span>
                            </div>
                            <div class="agenda-body">
                                <h4>{{ $session->formation->titre ?? 'Formation' }}</h4>
                                <p class="lieu">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        width="14" height="14">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $session->lieu ?? 'Lieu à préciser' }}
                                </p>
                                <p class="duree">
                                    @if ($session->date_fin)
                                        Du {{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                                        au {{ \Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y') }}
                                    @else
                                        À partir du
                                        {{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="agenda-cta">
                                <span class="places-badge">{{ $session->places_disponibles }} /
                                    {{ $session->places_totales }} places</span>
                                <a href="#register" class="btn btn-primary btn-sm">S'inscrire</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- ===================== PRESTATIONS ===================== -->
    <section id="prestations">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="kicker">Prestations &amp; appui-conseil</span>
                    <h2>Études, expertises et accompagnement technique</h2>
                    <p class="desc">L'ENEF met son expertise au service des structures publiques, privées et des
                        collectivités territoriales.</p>
                </div>
            </div>
            <div class="presta-grid">
                <div class="presta-card">
                    <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                            <path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4" />
                            <path d="M18 2l4 4-11 11H7v-4z" />
                        </svg></div>
                    <h4>Études &amp; études thématiques</h4>
                    <p>Études socio-économiques, plans d'aménagement, études d'impact environnemental, audits et
                        bilans carbone.</p>
                    <a href="#prestations" class="btn btn-outline btn-sm">Voir nos références</a>
                </div>
                <div class="presta-card">
                    <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg></div>
                    <h4>Appui-conseil &amp; accompagnement</h4>
                    <p>Planification environnementale, projets finance carbone, valorisation des savoirs locaux,
                        réhabilitation de sites miniers.</p>
                    <a href="mailto:infos@enef.gov.bf?subject=Demande%20de%20formation%20%C3%A0%20la%20carte"
                        class="btn btn-primary btn-sm">Découvrir nos missions</a>
                </div>
                <div class="presta-card">
                    <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                        </svg></div>
                    <h4>Demande de prestation</h4>
                    <p>Formulaire dédié pour formuler une demande d'étude ou d'appui-conseil, distinct de la demande
                        de formation.</p>
                    <a href="mailto:infos@enef.gov.bf?subject=Demande%20de%20formation%20%C3%A0%20la%20carte"
                        class="btn btn-primary btn-sm">Faire une demande</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== BIBLIOTHÈQUE ===================== -->
    <section id="bibliotheque" class="alt">
        <div class="container biblio">
            <div>
                <span class="kicker">Bibliothèque documentaire</span>
                <h2>Rapports, brochures et supports pédagogiques</h2>
                <p class="desc" style="margin-bottom:20px;">Parcourez le catalogue des ressources publiées par
                    l'ENEF : textes réglementaires, rapports, brochures et supports de formation, consultables à la
                    bibliothèque de l'école.</p>
                <a href="{{ route('bibliotheque.index') }}" class="btn btn-outline">Accéder aux documents</a>

                @if ($documentsRecents->isNotEmpty())
                    <div class="biblio-recent">
                        @foreach ($documentsRecents as $document)
                            <a href="{{ route('bibliotheque.index') }}" class="biblio-recent-item">
                                <span class="doc-type">{{ $typeLabels[$document->type] ?? $document->type }}</span>
                                <span class="doc-titre">{{ $document->titre }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="biblio-search">
                <form action="{{ route('bibliotheque.index') }}" method="GET" class="search-row">
                    <input type="text" name="q" placeholder="Rechercher un document, un thème…"
                        aria-label="Rechercher un document">
                    <button type="submit" aria-label="Lancer la recherche"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.3-4.3" />
                        </svg></button>
                </form>
                <div class="biblio-cats">
                    @forelse ($categoriesDocuments as $categorie)
                        <a href="{{ route('bibliotheque.index', ['categorie_id' => $categorie->id]) }}"
                            class="chip">{{ $categorie->nom }}</a>
                    @empty
                        <span class="chip">Aucune catégorie</span>
                    @endforelse
                </div>
                <div class="biblio-stats">
                    <div><span class="num">{{ $biblioStats['documents'] }}+</span><span class="lbl">Documents
                            référencés</span></div>
                    <div><span class="num">{{ $biblioStats['annees'] }}</span><span class="lbl">Années
                            d'archives</span></div>
                    <div><span class="num">{{ $biblioStats['thematiques'] }}</span><span class="lbl">Thématiques
                            classées</span></div>
                </div>
                <p class="biblio-note-home">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14"
                        height="14">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    Consultation sur place à la bibliothèque de l'ENEF, Bobo-Dioulasso.
                </p>
            </div>
        </div>
    </section>

    <!-- ===================== PARTENAIRES ===================== -->
    <section id="partenaires" class="alt">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="kicker">Nos partenaires</span>
                    <h2>Ils accompagnent l'ENEF dans ses missions</h2>
                </div>
            </div>
            <div class="partners-row">
                @forelse ($partenaires as $partenaire)
                    @if ($partenaire->site_web)
                        <a href="{{ $partenaire->site_web }}" class="partner-logo partner-logo-img" target="_blank"
                            rel="noopener" title="{{ $partenaire->description ?? $partenaire->nom }}">
                            <img src="{{ asset($partenaire->logo_url) }}" alt="{{ $partenaire->nom }}" loading="lazy">
                        </a>
                    @else
                        <div class="partner-logo partner-logo-img"
                            title="{{ $partenaire->description ?? $partenaire->nom }}">
                            <img src="{{ asset($partenaire->logo_url) }}" alt="{{ $partenaire->nom }}" loading="lazy">
                        </div>
                    @endif
                @empty
                    <p style="color:var(--ink-soft);">Aucun partenaire référencé pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===================== CHIFFRES CLÉS ===================== -->
    <section class="stats-band">
        <div class="container stats-grid">
            <div><span class="num">{{ $param_site->annee_creation ?? '—' }}</span><span class="lbl">Année de
                    création</span></div>
            <div><span class="num">{{ $param_site->personne_forme ?? '—' }} <strong>+</strong> </span><span class="lbl">Personnes
                    formées à nos jours
                    </span></div>
            <div><span class="num">{{ $fillieres->count() }}</span><span class="lbl">Profils de filières</span>
            </div>
            <div><span class="num">15+</span><span class="lbl">Partenaires techniques et financiers</span>
            </div>
        </div>
    </section>

    @include('partials.testimonial-dialog')

@endsection

@push('styles')
<style>
    /* ---------- Sessions dans les cartes de formation ---------- */
    .sessions-block { border-top: 1px solid var(--line); padding-top: 14px; margin-bottom: 16px; }
    .sessions-title { display: block; font-size: 12px; font-weight: 700; color: var(--water); text-transform: uppercase; letter-spacing: .03em; margin-bottom: 10px; }
    .sessions-list { display: flex; flex-direction: column; gap: 8px; }
    .session-item { display: flex; flex-direction: column; gap: 2px; font-size: 12.5px; background: var(--paper-alt); padding: 8px 10px; border-left: 2px solid var(--forest-accent); }
    .session-date { font-weight: 700; color: var(--forest-deep); }
    .session-lieu { color: var(--ink-soft); }
    .session-places { color: var(--water); font-weight: 600; }

    /* ---------- Agenda des sessions à venir ---------- */
    .sessions-agenda { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .agenda-card { display: flex; gap: 18px; align-items: flex-start; background: var(--white); border: 1px solid var(--line); padding: 20px; }
    .agenda-date { display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--forest-deep); color: #fff; min-width: 64px; padding: 10px 6px; flex-shrink: 0; }
    .agenda-date .day { font-family: "Fraunces", serif; font-size: 24px; font-weight: 680; line-height: 1; }
    .agenda-date .month { font-size: 12px; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
    .agenda-date .year { font-size: 11px; color: #c3d4bf; }
    .agenda-body { flex: 1; min-width: 0; }
    .agenda-body h4 { font-size: 16px; margin-bottom: 8px; }
    .agenda-body .lieu, .agenda-body .duree { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--ink-soft); margin-bottom: 4px; }
    .agenda-cta { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; flex-shrink: 0; }
    .places-badge { font-size: 11.5px; font-weight: 700; color: var(--water); background: var(--water-soft); padding: 4px 9px; white-space: nowrap; }

    @media (max-width: 640px) {
        .agenda-card { flex-direction: column; }
        .agenda-cta { align-items: flex-start; flex-direction: row; width: 100%; justify-content: space-between; }
    }

    /* ---------- Bibliothèque : documents récents ---------- */
    .biblio-recent { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
    .biblio-recent-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: var(--white); border: 1px solid var(--line); text-decoration: none; color: inherit; transition: border-color .2s ease; }
    .biblio-recent-item:hover { border-color: var(--forest-accent); }
    .biblio-recent-item .doc-type { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; color: var(--water); white-space: nowrap; }
    .biblio-recent-item .doc-titre { font-size: 14px; color: var(--ink); }
    .biblio-note-home { display: flex; align-items: center; gap: 6px; margin-top: 14px; font-size: 12.5px; color: var(--ink-soft); }
    .biblio-note-home svg { flex-shrink: 0; color: var(--forest-deep); }

    /* ---------- Partenaires ---------- */
    .partner-logo-img { display: flex; align-items: center; justify-content: center; text-decoration: none; cursor: default; }
    a.partner-logo-img { cursor: pointer; }
    .partner-logo-img img { max-height: 100%; max-width: 100%; object-fit: contain; transition: opacity .2s ease, transform .2s ease; }
    .partner-logo-img:hover img { transform: scale(1.05); }

    /* ---------- Témoignages défilants ---------- */
    .testi-marquee { overflow: hidden; padding: 12px 0 28px; -webkit-mask-image: linear-gradient(to right, transparent, #000 6%, #000 94%, transparent); mask-image: linear-gradient(to right, transparent, #000 6%, #000 94%, transparent); }
    .testi-track { display: flex; width: max-content; animation: testi-scroll 45s linear infinite; }
    .testi-marquee:hover .testi-track { animation-play-state: paused; }
    .testi-group { display: flex; gap: 24px; padding-right: 24px; }
    @keyframes testi-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    .testi-card { position: relative; display: flex; flex-direction: column; width: 360px; flex-shrink: 0; background: var(--white); border: 1px solid var(--line); border-top: 3px solid var(--forest-accent); padding: 28px 26px 22px; box-shadow: 0 6px 20px rgba(0,0,0,.05); transition: transform .25s ease, box-shadow .25s ease; }
    .testi-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,.10); }
    .testi-quote { position: absolute; top: 6px; right: 20px; font-family: "Fraunces", serif; font-size: 84px; line-height: 1; color: var(--forest-accent); opacity: .18; pointer-events: none; }
    .testi-stars { color: #e0a526; font-size: 16px; letter-spacing: 2px; margin-bottom: 14px; }
    .testi-body { flex: 1; margin-bottom: 16px; }
    .testi-text { margin: 0; font-size: 15px; line-height: 1.65; color: var(--ink); display: -webkit-box; -webkit-line-clamp: 6; -webkit-box-orient: vertical; overflow: hidden; }
    .testi-more { margin-top: 8px; padding: 0; background: none; border: 0; font: inherit; font-size: 12.5px; font-weight: 700; color: var(--water); text-decoration: underline; text-underline-offset: 3px; cursor: pointer; }
    .testi-more[hidden] { display: none; }
    .testi-more:hover { color: var(--forest-deep); }
    .testi-formation { align-self: flex-start; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; color: var(--water); background: var(--water-soft); padding: 4px 9px; margin-bottom: 18px; }
    .testi-who { display: flex; align-items: center; gap: 12px; border-top: 1px solid var(--line); padding-top: 16px; }
    .testi-avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .testi-avatar-initials { display: flex; align-items: center; justify-content: center; background: var(--forest-deep); color: #fff; font-family: "Fraunces", serif; font-size: 16px; font-weight: 680; }
    .testi-name { display: block; font-weight: 700; font-size: 14px; color: var(--forest-deep); }
    .testi-role { display: block; font-size: 12.5px; color: var(--ink-soft); margin-top: 2px; }

    @media (max-width: 640px) {
        .testi-card { width: 290px; padding: 24px 20px 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .testi-track { animation: none; }
        .testi-marquee { overflow-x: auto; -webkit-mask-image: none; mask-image: none; }
        .testi-group[aria-hidden="true"] { display: none; }
    }

    .testi-track--reverse { animation-direction: reverse; }

    .testi-marquee--compact { padding: 18px 0; background: var(--paper-alt); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .testi-marquee--compact .testi-group { gap: 16px; padding-right: 16px; }
    .testi-marquee--compact .testi-card { width: 300px; padding: 18px 18px 14px; border-top-width: 2px; box-shadow: none; }
    .testi-marquee--compact .testi-card:hover { transform: none; box-shadow: none; }
    .testi-marquee--compact .testi-quote { font-size: 60px; right: 14px; }
    .testi-marquee--compact .testi-stars { font-size: 14px; margin-bottom: 8px; }
    .testi-marquee--compact .testi-body { margin-bottom: 12px; }
    .testi-marquee--compact .testi-text { font-size: 13.5px; line-height: 1.5; -webkit-line-clamp: 3; }
    .testi-marquee--compact .testi-formation { display: none; }
    .testi-marquee--compact .testi-who { padding-top: 12px; }
    .testi-marquee--compact .testi-avatar { width: 36px; height: 36px; font-size: 14px; }

    @media (max-width: 640px) {
        .testi-marquee--compact .testi-card { width: 260px; }
    }

    /* ---------- Navigation du défilement des actualités ---------- */
    .news-slider { position: relative; margin: 0 -28px; }
    .news-slider .news-marquee { margin-left: 0; margin-right: 0; }
    .news-nav-btn { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid var(--line); border-radius: 50%; background: var(--white); color: var(--ink); font-size: 19px; line-height: 1; cursor: pointer; transition: border-color .15s ease, color .15s ease, background .15s ease; }
    .news-nav-btn:hover:not(:disabled) { border-color: var(--water); color: var(--water); background: rgba(20, 108, 104, .06); }
    .news-nav-btn:disabled { opacity: .45; cursor: default; }
    .news-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 3; }
    .news-arrow--left { left: 0; }
    .news-arrow--right { right: 0; }

    @media (max-width: 640px) {
        .news-arrow { width: 32px; height: 32px; font-size: 16px; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Navigation précédent / suivant du défilement des actualités
    (function () {
        var marquee = document.getElementById('news-marquee');
        if (!marquee) return;
        var track = marquee.querySelector('.news-track');
        var prevBtn = document.getElementById('news-prev');
        var nextBtn = document.getElementById('news-next');
        if (!track || !prevBtn || !nextBtn) return;

        var gap = 26;
        var pos = 0;

        function stepSize() {
            var card = track.querySelector('.news-card');
            if (!card) return 320 + gap;
            return card.getBoundingClientRect().width + gap;
        }

        function maxPos() {
            var uniqueWidth = (track.scrollWidth - gap) / 2;
            return -(uniqueWidth - marquee.clientWidth);
        }

        function updateButtons() {
            prevBtn.disabled = pos >= -1;
            nextBtn.disabled = pos <= maxPos() + 1;
        }

        function pause() {
            track.style.animation = 'none';
            track.style.transform = 'translateX(' + pos + 'px)';
        }

        function go(direction) {
            pause();
            pos = Math.round(Math.max(maxPos(), Math.min(0, pos - direction * stepSize())));
            track.style.transform = 'translateX(' + pos + 'px)';
            updateButtons();
        })();
    </script>
    <script>
        // Catalogue tabs (visuel)
        document.querySelectorAll('.tab-btn').forEach(function(tab) {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(function(t) {
                    t.setAttribute('aria-selected', 'false');
                });
                tab.setAttribute('aria-selected', 'true');
            });
        });

        document.querySelectorAll('.chip[data-filter-cat]').forEach(function (chip) {
            chip.addEventListener('click', function () {
                var wasActive = chip.classList.contains('chip-active');
                document.querySelectorAll('.chip[data-filter-cat]').forEach(function (c) {
                    c.classList.remove('chip-active');
                });
                activeCat = wasActive ? null : chip.dataset.filterCat;
                if (!wasActive) chip.classList.add('chip-active');
                applyFilters();
            });
        });

            document.querySelectorAll('.chip[data-filter-cat]').forEach(function(chip) {
                chip.addEventListener('click', function() {
                    var wasActive = chip.classList.contains('chip-active');
                    document.querySelectorAll('.chip[data-filter-cat]').forEach(function(c) {
                        c.classList.remove('chip-active');
                    });
                    activeCat = wasActive ? null : chip.dataset.filterCat;
                    if (!wasActive) chip.classList.add('chip-active');
                    applyFilters();
                });
            });

            applyFilters(); // état initial : onglet "Programmées"
        })();
    </script>
@endpush
