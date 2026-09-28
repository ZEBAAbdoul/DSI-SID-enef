{{--
    Carrousel circulaire 3D « Actualités à la une » (hero de l'accueil).

    Usage : remplacer le bloc <div class="hero-side"> … </div> de accueil.blade.php par
        @include('partials.hero-actualites-ring')

    Données (dans l'ordre de priorité) :
        $dernieresActualites  → les 5 dernières actualités publiées (à passer depuis le contrôleur)
        $actualites           → repli : les 5 premières
        $derniereActualite    → repli : une seule carte
--}}
@php
    $typesActu = [
        'institutionnelle' => 'Institutionnel',
        'formation' => 'Formation',
        'evenement' => 'Événement',
        'partenariat' => 'Partenariat',
        'communique' => 'Communiqué',
    ];

    $sourceActus = collect($dernieresActualites ?? ($actualites ?? []))
        ->filter()
        ->take(5);
    if ($sourceActus->isEmpty() && !empty($derniereActualite)) {
        $sourceActus = collect([$derniereActualite]);
    }

    $ringSlides = $sourceActus
        ->map(function ($a) use ($typesActu) {
            $dateBrute = $a->date_publication ?? $a->created_at;
            return [
                'image' => $a->image ?: asset('images/actualite1.jpg'),
                'titre' => $a->titre,
                'texte' => \Illuminate\Support\Str::limit(strip_tags($a->chapo ?? ($a->resume ?? '')), 160),
                'type' => $typesActu[$a->type ?? ''] ?? 'Actualité',
                'date' => $dateBrute ? \Carbon\Carbon::parse($dateBrute)->translatedFormat('d M Y') : null,
                'url' => route('actualites.show', $a->slug),
                'cta' => "Lire l'actualité",
            ];
        })
        ->values();

    if ($ringSlides->isEmpty()) {
        $ringSlides = collect([
            [
                'image' => asset('images/actualite1.jpg'),
                'titre' => 'Ouverture des candidatures — session 2026/2027',
                'texte' =>
                    "Les inscriptions pour le concours d'entrée en formation initiale et les sessions de formation continue sont ouvertes jusqu'au 15 octobre 2026.",
                'type' => 'Admissions',
                'date' => null,
                'url' => '#admissions',
                'cta' => "Voir les conditions d'accès",
            ],
        ]);
    }

    $ringCount = $ringSlides->count();
    $ringMulti = $ringCount > 1;
@endphp

<div class="hero-side hero-side--ring" id="heroRing" role="region" aria-roledescription="carrousel"
    aria-label="Actualités à la une">

    {{-- Fonds flous (fondu enchaîné selon l'actualité active) --}}
    @foreach ($ringSlides as $i => $s)
        <img src="{{ $s['image'] }}" alt="" aria-hidden="true"
            class="hero-side-photo ring-bg {{ $i === 0 ? 'is-active' : '' }}">
    @endforeach

    <div class="ring-head">
        <span class="tag">Actualités à la une</span>
        @if ($ringMulti)
            <div class="ring-head-right">
                <button type="button" class="ring-pause" aria-pressed="false"
                    aria-label="Mettre en pause le défilement">
                    <svg class="i-pause" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"
                        aria-hidden="true">
                        <rect x="6" y="5" width="4" height="14" rx="1" />
                        <rect x="14" y="5" width="4" height="14" rx="1" />
                    </svg>
                    <svg class="i-play" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"
                        aria-hidden="true">
                        <path d="M7 5l12 7-12 7z" />
                    </svg>
                </button>
                <span class="ring-count" aria-hidden="true"><b class="ring-cur">1</b> / {{ $ringCount }}</span>
            </div>
        @endif
    </div>

    {{-- Anneau 3D --}}
    <div class="ring-stage">
        <span class="ring-orbit" aria-hidden="true"></span>
        <span class="ring-floor" aria-hidden="true"></span>
        <div class="ring">
            @foreach ($ringSlides as $i => $s)
                <a href="{{ $s['url'] }}" class="ring-card {{ $i === 0 ? 'is-active' : '' }}" tabindex="-1"
                    aria-hidden="true" draggable="false">
                    <img src="{{ $s['image'] }}" alt="" draggable="false"
                        loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                    <span class="ring-badge">{{ $s['type'] }}</span>
                    @if ($s['date'])
                        <span class="ring-date">{{ $s['date'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- Texte de l'actualité active --}}
    <div class="ring-info">
        @foreach ($ringSlides as $i => $s)
            <article class="ring-info-item {{ $i === 0 ? 'is-active' : '' }}">
                <h4>{{ $s['titre'] }}</h4>
                {{-- @if ($s['texte'])
                    <p>{{ $s['texte'] }}</p>
                @endif --}}
                {{-- <a href="{{ $s['url'] }}" class="btn btn-water btn-sm">{{ $s['cta'] }}</a> --}}
            </article>
        @endforeach
    </div>

    @if ($ringMulti)
        <div class="ring-ctl">
            <button type="button" class="ring-btn ring-prev" aria-label="Actualité précédente">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 6l-6 6 6 6" />
                </svg>
            </button>

            <div class="ring-dots" role="tablist" aria-label="Choisir une actualité">
                @foreach ($ringSlides as $i => $s)
                    <button type="button" class="ring-dot {{ $i === 0 ? 'is-active' : '' }}" role="tab"
                        aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                        aria-label="Actualité {{ $i + 1 }} : {{ $s['titre'] }}">
                        <span class="bar"><span class="fill"></span></span>
                    </button>
                @endforeach
            </div>

            <button type="button" class="ring-btn ring-next" aria-label="Actualité suivante">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </button>
        </div>
    @endif
</div>

@push('styles')
    <style>
        /* ================= Hero : carrousel circulaire des actualités ================= */
        .hero-side.hero-side--ring {
            --card-w: 240px;
            --card-h: 285px;
            justify-content: space-between;
            gap: 10px;
            padding: 22px 26px;
            min-height: 560px;
        }

        /* On neutralise l'animation d'entrée générique du hero pour ces éléments */
        .hero-side.hero-side--ring .tag,
        .hero-side.hero-side--ring h3,
        .hero-side.hero-side--ring p,
        .hero-side.hero-side--ring .btn {
            animation: none;
            opacity: 1;
            transform: none;
        }

        /* ---------- Fonds flous ---------- */
        .hero-side.hero-side--ring img.ring-bg {
            inset: -28px;
            width: calc(100% + 56px);
            height: calc(100% + 56px);
            opacity: 0;
            filter: blur(12px) saturate(1.15);
            animation: none;
            transition: opacity 1s ease;
        }

        .hero-side.hero-side--ring img.ring-bg.is-active {
            opacity: 1;
        }

        /* ---------- En-tête ---------- */
        .ring-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .ring-head-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ring-count {
            font-family: "Fraunces", serif;
            font-size: 15px;
            color: #c9dcc4;
            letter-spacing: .04em;
        }

        .ring-count b {
            font-size: 24px;
            font-weight: 560;
            color: #fff;
        }

        .ring-pause {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .6);
            background: rgba(255, 255, 255, .22);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .15s ease;
        }

        .ring-pause:hover {
            background: rgba(255, 255, 255, .4);
        }

        .ring-pause .i-play {
            display: none;
        }

        .hero-side--ring.is-stopped .ring-pause .i-pause {
            display: none;
        }

        .hero-side--ring.is-stopped .ring-pause .i-play {
            display: block;
        }

        /* ---------- Scène 3D ---------- */
        .ring-stage {
            position: relative;
            height: 320px;
            perspective: 1100px;
            perspective-origin: 50% 40%;
            touch-action: pan-y;
            cursor: grab;
            user-select: none;
            -webkit-user-select: none;
            animation: ringStageIn .9s cubic-bezier(.19, 1, .22, 1) .1s both;
        }

        .hero-side--ring.is-dragging .ring-stage {
            cursor: grabbing;
        }

        @keyframes ringStageIn {
            from {
                opacity: 0;
                transform: translateY(18px) scale(.96);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .ring {
            position: absolute;
            left: 50%;
            top: 46%;
            width: var(--card-w);
            height: var(--card-h);
            margin: calc(var(--card-h) / -2) 0 0 calc(var(--card-w) / -2);
            transform-style: preserve-3d;
            transition: transform 1.1s cubic-bezier(.22, .85, .25, 1);
            will-change: transform;
        }

        /* Avant l'initialisation JS : une seule carte visible, à plat */
        .ring:not(.is-ready) .ring-card:not(:first-child) {
            visibility: hidden;
        }

        .ring-card {
            position: absolute;
            inset: 0;
            display: block;
            overflow: hidden;
            border-radius: 12px;
            background: #173226;
            border: 1px solid rgba(255, 255, 255, .22);
            box-shadow: 0 26px 44px -22px rgba(0, 0, 0, .75);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .ring-card img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
        }

        /* Dégradés haut/bas pour la lisibilité du badge et de la date */
        .ring-card::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg, rgba(0, 0, 0, .3) 0%, transparent 30%, transparent 60%, rgba(8, 20, 14, .75) 100%);
        }

        /* Assombrissement des cartes qui ne sont pas au premier plan */
        .ring-card::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 4;
            background: rgba(8, 20, 14, .6);
            opacity: 1;
            transition: opacity .9s ease;
            pointer-events: none;
        }

        .ring-card.is-near::after {
            opacity: .55;
        }

        .ring-card.is-active::after {
            opacity: 0;
        }

        .ring-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            z-index: 3;
            background: var(--clay);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 11px;
            border-radius: 999px;
        }

        .ring-date {
            position: absolute;
            left: 14px;
            bottom: 12px;
            z-index: 3;
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
            text-shadow: 0 1px 6px rgba(0, 0, 0, .6);
        }

        /* Ellipse au sol : l'orbite sur laquelle tournent les cartes */
        .ring-orbit {
            position: absolute;
            left: 50%;
            bottom: 4px;
            width: 92%;
            height: 64px;
            transform: translateX(-50%);
            border: 1px dashed rgba(255, 255, 255, .25);
            border-radius: 50%;
            pointer-events: none;
        }

        .ring-floor {
            position: absolute;
            left: 50%;
            bottom: 14px;
            width: 62%;
            height: 30px;
            transform: translateX(-50%);
            background: radial-gradient(ellipse at center, rgba(0, 0, 0, .55) 0%, transparent 70%);
            filter: blur(6px);
            pointer-events: none;
        }

        /* ---------- Texte de l'actualité active ---------- */
        .ring-info {
            display: grid;
            margin-top: 6px;
        }

        .ring-info-item {
            grid-area: 1 / 1;
            opacity: 0;
            visibility: hidden;
            transform: translateY(14px);
            transition: opacity .35s ease, transform .35s ease, visibility 0s linear .35s;
        }

        .ring-info-item.is-active {
            opacity: 1;
            visibility: visible;
            transform: none;
            transition: opacity .6s ease .25s, transform .7s cubic-bezier(.19, 1, .22, 1) .25s, visibility 0s;
        }

        .hero-side.hero-side--ring h3 {
            font-size: 24px;
            line-height: 1.2;
            max-width: none;
            margin: 0 0 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-side.hero-side--ring p {
            font-size: 14.5px;
            line-height: 1.5;
            max-width: 56ch;
            margin: 0 0 14px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ---------- Commandes ---------- */
        .ring-ctl {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 12px;
        }

        .ring-btn {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border: 0;
            border-radius: 50%;
            background: #fff;
            color: #1b5e20;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px -6px rgba(0, 0, 0, .5);
            transition: transform .15s ease, background .15s ease;
        }

        .ring-btn:hover {
            background: #eaf4e6;
            transform: scale(1.07);
        }

        .ring-btn:active {
            transform: scale(.96);
        }

        .ring-btn svg {
            width: 18px;
            height: 18px;
        }

        .ring-dots {
            display: flex;
            align-items: center;
        }

        .ring-dot {
            background: none;
            border: 0;
            padding: 10px 4px;
        }

        .ring-dot .bar {
            display: block;
            position: relative;
            width: 10px;
            height: 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, .4);
            overflow: hidden;
            transition: width .45s cubic-bezier(.19, 1, .22, 1), background .3s ease;
        }

        .ring-dot:hover .bar {
            background: rgba(255, 255, 255, .65);
        }

        .ring-dot.is-active .bar {
            width: 44px;
        }

        .ring-dot .fill {
            position: absolute;
            inset: 0;
            background: #fff;
            transform: scaleX(0);
            transform-origin: left center;
        }

        /* La fin de cette animation déclenche l'actualité suivante (lecture automatique) */
        .ring-dot.is-active .fill {
            animation: ringFill 3.5s linear forwards;
        }

        @keyframes ringFill {
            to {
                transform: scaleX(1);
            }
        }

        /* Pause : survol, focus clavier, glissement, onglet masqué, hors écran, bouton pause */
        .hero-side--ring:hover .ring-dot.is-active .fill,
        .hero-side--ring.is-focus .ring-dot.is-active .fill,
        .hero-side--ring.is-dragging .ring-dot.is-active .fill,
        .hero-side--ring.is-paused .ring-dot.is-active .fill,
        .hero-side--ring.is-stopped .ring-dot.is-active .fill {
            animation-play-state: paused;
        }

        /* ---------- Mobile ---------- */
        @media (max-width: 640px) {
            .hero-side.hero-side--ring {
                --card-w: 210px;
                --card-h: 250px;
                padding: 18px 16px;
                min-height: 0;
            }

            .ring-stage {
                height: 280px;
            }

            .hero-side.hero-side--ring h3 {
                font-size: 20px;
            }
        }

        /* ---------- Mouvement réduit : pas de lecture automatique, transitions coupées ---------- */
        @media (prefers-reduced-motion: reduce) {

            .ring,
            .ring-info-item,
            .ring-card::after,
            .hero-side.hero-side--ring img.ring-bg {
                transition: none !important;
            }

            .ring-stage {
                animation: none;
            }

            .ring-dot.is-active .fill {
                animation: none;
                transform: scaleX(1);
            }

            .ring-pause {
                display: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Carrousel circulaire 3D des actualités (hero)
        (function() {
            var root = document.getElementById('heroRing');
            if (!root) return;
            var cards = [].slice.call(root.querySelectorAll('.ring-card'));
            var n = cards.length;
            if (n < 2) return;

            var ring = root.querySelector('.ring');
            var stage = root.querySelector('.ring-stage');
            var infos = [].slice.call(root.querySelectorAll('.ring-info-item'));
            var bgs = [].slice.call(root.querySelectorAll('.ring-bg'));
            var dots = [].slice.call(root.querySelectorAll('.ring-dot'));
            var cur = root.querySelector('.ring-cur');
            var pauseBtn = root.querySelector('.ring-pause');

            var step = 360 / n; // angle entre deux cartes
            var half = Math.floor(n / 2);
            var R = 240; // rayon du cylindre (recalculé selon la largeur des cartes)
            var current = 0; // index "déroulé" : peut dépasser n pour tourner toujours dans le même sens
            var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;

            function mod(a, b) {
                return ((a % b) + b) % b;
            }

            function render(offset) {
                ring.style.transform = 'translateZ(' + (-R) + 'px) rotateY(' + (-current * step + (offset || 0)) +
                    'deg)';
            }

            function layout() {
                var w = cards[0].offsetWidth || 240;
                R = Math.max(190, Math.round((w / 2) / Math.tan(Math.PI / n)));
                cards.forEach(function(c, i) {
                    c.style.transform = 'rotateY(' + (i * step) + 'deg) translateZ(' + R + 'px)';
                });
                render(0);
            }

            function sync() {
                var idx = mod(current, n);
                cards.forEach(function(c, i) {
                    var rel = mod(i - idx + half, n) - half;
                    c.classList.toggle('is-active', rel === 0);
                    c.classList.toggle('is-near', Math.abs(rel) === 1);
                });
                infos.forEach(function(el, i) {
                    el.classList.toggle('is-active', i === idx);
                });
                bgs.forEach(function(el, i) {
                    el.classList.toggle('is-active', i === idx);
                });
                dots.forEach(function(d, i) {
                    d.classList.toggle('is-active', i === idx);
                    d.setAttribute('aria-selected', i === idx ? 'true' : 'false');
                });
                if (cur) cur.textContent = idx + 1;
            }

            function go(dir) {
                current += dir;
                render(0);
                sync();
            }

            function goTo(i) {
                var rel = mod(i - mod(current, n) + half, n) - half; // chemin le plus court
                if (!rel) return;
                current += rel;
                render(0);
                sync();
            }

            // ----- Initialisation + entrée en rotation -----
            layout();
            sync();
            ring.classList.add('is-ready');
            if (!reduce) {
                ring.style.transition = 'none';
                render(-160);
                void ring.offsetWidth;
                ring.style.transition = '';
                render(0);
            }

            var t;
            window.addEventListener('resize', function() {
                clearTimeout(t);
                t = setTimeout(layout, 150);
            });

            // ----- Commandes -----
            root.querySelector('.ring-prev').addEventListener('click', function() {
                go(-1);
            });
            root.querySelector('.ring-next').addEventListener('click', function() {
                go(1);
            });
            dots.forEach(function(d, i) {
                d.addEventListener('click', function() {
                    goTo(i);
                });
                // Lecture automatique : quand la barre de progression est pleine, on passe à la suivante
                d.querySelector('.fill').addEventListener('animationend', function() {
                    if (d.classList.contains('is-active')) go(1);
                });
            });
            root.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    go(-1);
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    go(1);
                }
            });

            // ----- Glisser (souris / tactile) : la carte voisine ramène l'anneau vers elle -----
            var dragging = false,
                moved = false,
                startX = 0,
                dx = 0;

            function onMove(e) {
                dx = e.clientX - startX;
                if (Math.abs(dx) > 6) moved = true;
                render(dx * 0.35);
            }

            function onUp() {
                if (!dragging) return;
                dragging = false;
                window.removeEventListener('pointermove', onMove);
                window.removeEventListener('pointerup', onUp);
                window.removeEventListener('pointercancel', onUp);
                ring.style.transition = '';
                root.classList.remove('is-dragging');
                if (dx < -50) go(1);
                else if (dx > 50) go(-1);
                else render(0);
                setTimeout(function() {
                    moved = false;
                }, 0);
            }
            stage.addEventListener('pointerdown', function(e) {
                if (e.pointerType === 'mouse' && e.button !== 0) return;
                dragging = true;
                moved = false;
                startX = e.clientX;
                dx = 0;
                ring.style.transition = 'none';
                root.classList.add('is-dragging');
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
                window.addEventListener('pointercancel', onUp);
            });

            // Clic sur une carte : voisine → la ramener devant ; carte active → ouvrir l'actualité
            cards.forEach(function(c, i) {
                c.addEventListener('click', function(e) {
                    if (moved) {
                        e.preventDefault();
                        return;
                    }
                    if (!c.classList.contains('is-active')) {
                        e.preventDefault();
                        goTo(i);
                    }
                });
            });

            // ----- Pause automatique (onglet masqué, carrousel hors écran, focus clavier) -----
            var off = false;

            function syncPause() {
                root.classList.toggle('is-paused', document.hidden || off);
            }
            document.addEventListener('visibilitychange', syncPause);
            if ('IntersectionObserver' in window) {
                new IntersectionObserver(function(entries) {
                    off = !entries[0].isIntersecting;
                    syncPause();
                }, {
                    threshold: .2
                }).observe(root);
            }
            root.addEventListener('focusin', function(e) {
                var visible = false;
                try {
                    visible = e.target.matches(':focus-visible');
                } catch (_) {}
                root.classList.toggle('is-focus', visible);
            });
            root.addEventListener('focusout', function() {
                root.classList.remove('is-focus');
            });

            // ----- Bouton pause / lecture -----
            if (pauseBtn) {
                pauseBtn.addEventListener('click', function() {
                    var stopped = root.classList.toggle('is-stopped');
                    pauseBtn.setAttribute('aria-pressed', stopped ? 'true' : 'false');
                    pauseBtn.setAttribute('aria-label', stopped ? 'Reprendre le défilement' :
                        'Mettre en pause le défilement');
                });
            }
        })();
    </script>
@endpush
