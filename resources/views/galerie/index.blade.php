@extends('layouts.site')

@section('title', 'ENEF — Galerie photo & vidéo')

@push('styles')
    <style>
        /* ---------- En-tête compact ---------- */
        .hero-compact {
            padding: 26px 0 24px;
        }

        .hero-compact .eyebrow-line {
            margin-bottom: 6px;
            font-size: 12px;
        }

        .hero-compact h1 {
            font-size: clamp(23px, 2.7vw, 30px);
            margin-bottom: 6px;
            max-width: none;
        }

        .hero-compact .hero-lede {
            font-size: 14px;
            max-width: 64ch;
            margin-bottom: 0;
        }

        /* ---------- Onglets Photos / Vidéos ---------- */
        .gal-tabs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 34px;
            flex-wrap: wrap;
        }

        .gal-tab {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 12px 26px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 2px;
            border: 1.5px solid var(--forest-deep);
            background: var(--white);
            color: var(--forest-deep);
            cursor: pointer;
            font-family: inherit;
        }

        .gal-tab:hover {
            background: var(--forest-deep);
            color: #fff;
        }

        .gal-tab.active {
            background: var(--forest-deep);
            color: #fff;
        }

        .gal-tab .count {
            font-size: 12px;
            background: var(--clay);
            color: #fff;
            border-radius: 20px;
            padding: 2px 9px;
        }

        .gal-tab.active .count {
            background: var(--clay);
        }

        .gal-panel {
            display: none;
        }

        .gal-panel.active {
            display: block;
        }

        /* ---------- Carrousel 2×4 (pagination numérotée) ---------- */
        .gal-carousel {
            position: relative;
        }

        .gal-page {
            display: none;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, auto);
            gap: 22px;
        }

        .gal-page.active {
            display: grid;
        }

        .gal-pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
            flex-wrap: wrap;
        }

        .gal-pbtn {
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: 2px;
            border: 1.5px solid var(--forest-deep);
            background: var(--white);
            color: var(--forest-deep);
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease, color .2s ease;
        }

        .gal-pbtn:hover {
            background: var(--paper-alt);
        }

        .gal-pbtn.active {
            background: var(--forest-deep);
            color: #fff;
        }

        /* ---------- Cartes photos ---------- */
        .gal-card {
            background: var(--white);
            border: 1px solid var(--line);
            cursor: pointer;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .gal-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .gal-thumb {
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--forest-mid), var(--water));
            overflow: hidden;
            position: relative;
        }

        .gal-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .5s ease;
        }

        .gal-card:hover .gal-thumb img {
            transform: scale(1.06);
        }

        .gal-thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(21, 42, 32, 0) 55%, rgba(15, 30, 22, .5) 100%);
            opacity: 0;
            transition: opacity .3s ease;
        }

        .gal-card:hover .gal-thumb::after {
            opacity: 1;
        }

        .gal-body {
            padding: 13px 16px 15px;
        }

        .gal-body h3 {
            font-size: 15px;
            margin: 0 0 3px;
        }

        .gal-body p {
            font-size: 13.5px;
            color: var(--ink-soft);
            margin: 0;
        }

        /* ---------- Cartes vidéos ---------- */
        .gal-vcard {
            background: var(--white);
            border: 1px solid var(--line);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .gal-vcard:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .gal-vframe {
            position: relative;
            aspect-ratio: 16/9;
            background: #0b140f;
            overflow: hidden;
        }

        .gal-vframe .gal-vthumb {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-color: #10241a;
        }

        .gal-vframe .gal-vthumb.no-thumb {
            background: linear-gradient(135deg, var(--forest-mid), var(--water));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #cfe0cc;
            font-size: 13px;
            font-weight: 600;
        }

        .gal-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .9);
            background: rgba(15, 30, 22, .55);
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: transform .2s ease, background .2s ease;
            padding-left: 4px;
        }

        .gal-play:hover {
            background: rgba(15, 30, 22, .8);
            transform: translate(-50%, -50%) scale(1.08);
        }

        .gal-vembed {
            position: absolute;
            inset: 0;
            display: none;
        }

        .gal-vembed iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }

        .gal-vbody {
            padding: 14px 16px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .gal-vplatform {
            align-self: flex-start;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 3px 8px;
            background: var(--water-soft);
            color: var(--water);
            margin-bottom: 8px;
        }

        .gal-vbody h3 {
            font-size: 15px;
            margin: 0 0 6px;
        }

        .gal-vbody p {
            font-size: 13px;
            color: var(--ink-soft);
            margin: 0;
            flex: 1;
        }

        .gal-vlink {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--forest-mid);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .gal-vlink svg {
            width: 12px;
            height: 12px;
        }

        .gal-empty {
            text-align: center;
            color: var(--ink-soft);
            padding: 46px 0;
        }

        /* ---------- Lightbox photos ---------- */
        .galerie-lightbox {
            position: fixed;
            inset: 0;
            background: rgba(10, 18, 13, .95);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .galerie-lightbox.open {
            display: flex;
        }

        .galerie-lb-card {
            max-width: 960px;
            width: 100%;
            background: var(--white);
        }

        .galerie-lb-card img {
            width: 100%;
            max-height: 76vh;
            object-fit: contain;
            background: #0b140f;
        }

        .galerie-lb-body {
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .galerie-lb-body h3 {
            font-size: 18px;
            margin: 0 0 4px;
        }

        .galerie-lb-body p {
            margin: 0;
            font-size: 14px;
            color: var(--ink-soft);
        }

        .galerie-lb-count {
            font-size: 13px;
            color: var(--ink-soft);
            white-space: nowrap;
            padding-top: 4px;
        }

        .galerie-lb-close {
            position: absolute;
            top: 18px;
            right: 22px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .5);
            background: rgba(255, 255, 255, .08);
            color: #fff;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .galerie-lb-close:hover {
            background: rgba(255, 255, 255, .2);
        }

        .galerie-lb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .4);
            background: rgba(255, 255, 255, .08);
            color: #fff;
            font-size: 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .galerie-lb-nav:hover {
            background: rgba(255, 255, 255, .2);
        }

        .galerie-lb-prev {
            left: 22px;
        }

        .galerie-lb-next {
            right: 22px;
        }

        @media (max-width: 980px) {
            .gal-page {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 560px) {
            .gal-page {
                grid-template-columns: 1fr;
            }

            .galerie-lightbox {
                padding: 18px;
            }

            .galerie-lb-nav {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            .galerie-lb-prev {
                left: 8px;
            }

            .galerie-lb-next {
                right: 8px;
            }
        }
    </style>
@endpush

@section('content')

    @php
        $photoPages = $photos->chunk(8);
        $videoPages = $videos->chunk(8);
    @endphp

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero hero-compact">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Galerie photo &amp; vidéo</div>
            <h1>La vie de l'établissement en images</h1>
            <p class="hero-lede">Cours pratiques, cérémonies et moments forts de l'ENEF, en photos et en vidéos.</p>
        </div>
    </section>

    <!-- ===================== GALERIE ===================== -->
    <section id="galerie" class="alt">
        <div class="container">

            {{-- Onglets Photos / Vidéos --}}
            <div class="gal-tabs" role="tablist" aria-label="Type de médias">
                <button type="button" class="gal-tab {{ $type === 'photos' ? 'active' : '' }}"
                        data-panel="galPhotos" role="tab" aria-selected="{{ $type === 'photos' ? 'true' : 'false' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <circle cx="9" cy="10" r="1.5" />
                        <path d="M21 15l-5-5-8 8" />
                    </svg>
                    Photos
                    <span class="count">{{ $photos->count() }}</span>
                </button>
                <button type="button" class="gal-tab {{ $type === 'videos' ? 'active' : '' }}"
                        data-panel="galVideos" role="tab" aria-selected="{{ $type === 'videos' ? 'true' : 'false' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 7l-7 5 7 5V7z" />
                        <rect x="1" y="5" width="15" height="14" rx="2" />
                    </svg>
                    Vidéos
                    <span class="count">{{ $videos->count() }}</span>
                </button>
            </div>

            {{-- ============ PANEL PHOTOS ============ --}}
            <div id="galPhotos" class="gal-panel {{ $type === 'photos' ? 'active' : '' }}" role="tabpanel">

                @if ($photos->isNotEmpty())

                    <div class="gal-carousel" data-carousel="photos">

                        @foreach ($photoPages as $pageIndex => $page)
                            <div class="gal-page {{ $pageIndex === 0 ? 'active' : '' }}">
                                @foreach ($page as $photo)
                                    <div class="gal-card" role="button" tabindex="0"
                                         onclick="ouvrirGalerie({{ $loop->parent->index * 4 + $loop->index }})"
                                         onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();ouvrirGalerie({{ $loop->parent->index * 4 + $loop->index }});}">
                                        <div class="gal-thumb">
                                            <img src="{{ asset($photo->image_url) }}" alt="{{ $photo->titre }}" loading="lazy">
                                        </div>
                                        <div class="gal-body">
                                            <h3>{{ $photo->titre }}</h3>
                                            @if ($photo->description)
                                                <p>{{ \Illuminate\Support\Str::limit($photo->description, 80) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        @if ($photoPages->count() > 1)
                            <div class="gal-pagination">
                                @foreach ($photoPages as $pageNum => $page)
                                    <button type="button" class="gal-pbtn {{ $pageNum === 0 ? 'active' : '' }}"
                                            data-page="{{ $pageNum }}" aria-label="Page {{ $pageNum + 1 }}">
                                        {{ $pageNum + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                    </div>

                @else
                    <p class="gal-empty">Aucune photo disponible pour le moment.</p>
                @endif

            </div>

            {{-- ============ PANEL VIDÉOS ============ --}}
            <div id="galVideos" class="gal-panel {{ $type === 'videos' ? 'active' : '' }}" role="tabpanel">

                @if ($videos->isNotEmpty())

                    <div class="gal-carousel" data-carousel="videos">

                        @foreach ($videoPages as $pageIndex => $page)
                            <div class="gal-page {{ $pageIndex === 0 ? 'active' : '' }}">
                                @foreach ($page as $video)
                                    <div class="gal-vcard">
                                        <div class="gal-vframe">
                                            <div class="gal-vthumb {{ $video->thumbnail_url ? '' : 'no-thumb' }}"
                                                 @if ($video->thumbnail_url)
                                                     style="background-image:url('{{ $video->thumbnail_url }}');"
                                                 @endif>
                                                @if (!$video->thumbnail_url)
                                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                        <path d="M23 7l-7 5 7 5V7z" />
                                                        <rect x="1" y="5" width="15" height="14" rx="2" />
                                                    </svg>
                                                    <span>{{ $video->platform }}</span>
                                                @endif
                                            </div>

                                            @if ($video->embed_url)
                                                <button type="button" class="gal-play" aria-label="Lire « {{ $video->titre }} »" onclick="jouerVideo(this)">&#9654;</button>
                                                <div class="gal-vembed" aria-hidden="true">
                                                    <iframe data-src="{{ $video->embed_url }}" title="{{ $video->titre }}"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen tabindex="-1"></iframe>
                                                </div>
                                            @else
                                                <a class="gal-play" href="{{ $video->url }}" target="_blank" rel="noopener noreferrer" aria-label="Ouvrir « {{ $video->titre }} »">&#9654;</a>
                                            @endif
                                        </div>

                                        <div class="gal-vbody">
                                            <span class="gal-vplatform">{{ $video->platform }}</span>
                                            <h3>{{ $video->titre }}</h3>
                                            @if ($video->description)
                                                <p>{{ \Illuminate\Support\Str::limit($video->description, 70) }}</p>
                                            @endif
                                            <a href="{{ $video->url }}" target="_blank" rel="noopener noreferrer" class="gal-vlink">
                                                Ouvrir sur {{ $video->platform }}
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M7 17 17 7M9 7h8v8" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        @if ($videoPages->count() > 1)
                            <div class="gal-pagination">
                                @foreach ($videoPages as $pageNum => $page)
                                    <button type="button" class="gal-pbtn {{ $pageNum === 0 ? 'active' : '' }}"
                                            data-page="{{ $pageNum }}" aria-label="Page {{ $pageNum + 1 }}">
                                        {{ $pageNum + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                    </div>

                @else
                    <p class="gal-empty">Aucune vidéo disponible pour le moment.</p>
                @endif

            </div>

        </div>
    </section>

@endsection

@push('scripts')

    @if ($photos->isNotEmpty())
        @php
            $galeriePhotos = $photos->map(fn ($p) => [
                'image' => asset($p->image_url),
                'titre' => $p->titre,
                'description' => $p->description,
            ])->values();
        @endphp
        <script>
            window.galeriePhotos = @json($galeriePhotos);
            var galerieIndex = 0;

            function ouvrirGalerie(index) {
                galerieIndex = index;
                afficherGalerie();
                document.getElementById('galerieLightbox').classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function fermerGalerie() {
                document.getElementById('galerieLightbox').classList.remove('open');
                document.body.style.overflow = '';
            }

            function afficherGalerie() {
                var photo = window.galeriePhotos[galerieIndex];
                document.getElementById('galerieLbImg').src = photo.image;
                document.getElementById('galerieLbImg').alt = photo.titre;
                document.getElementById('galerieLbTitre').textContent = photo.titre;
                var desc = document.getElementById('galerieLbDesc');
                desc.textContent = photo.description || '';
                desc.style.display = photo.description ? '' : 'none';
                document.getElementById('galerieLbCount').textContent =
                    (galerieIndex + 1) + ' / ' + window.galeriePhotos.length;
            }

            function galerieSuivante() {
                galerieIndex = (galerieIndex + 1) % window.galeriePhotos.length;
                afficherGalerie();
            }

            function galeriePrecedente() {
                galerieIndex = (galerieIndex - 1 + window.galeriePhotos.length) % window.galeriePhotos.length;
                afficherGalerie();
            }

            document.addEventListener('DOMContentLoaded', function() {
                var lib = document.getElementById('galerieLightbox');
                lib.addEventListener('click', function(e) {
                    if (e.target === lib) {
                        fermerGalerie();
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (!lib.classList.contains('open')) return;
                    if (e.key === 'Escape') fermerGalerie();
                    else if (e.key === 'ArrowRight') galerieSuivante();
                    else if (e.key === 'ArrowLeft') galeriePrecedente();
                });
            });
        </script>
    @endif

    <script>
        // ---------- Basculer Photos / Vidéos ----------
        document.querySelectorAll('.gal-tab').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.gal-tab').forEach(function(b) {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                document.querySelectorAll('.gal-panel').forEach(function(p) {
                    p.classList.remove('active');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
                document.getElementById(btn.dataset.panel).classList.add('active');
            });
        });

        // ---------- Pages 2×4 : pagination numérotée ----------
        document.querySelectorAll('.gal-pagination').forEach(function(pag) {
            var car = pag.closest('.gal-carousel');
            if (!car) return;

            var pages = car.querySelectorAll('.gal-page');
            var btns = pag.querySelectorAll('.gal-pbtn');

            function aller(idx) {
                pages.forEach(function(p, i) {
                    p.classList.toggle('active', i === idx);
                });
                btns.forEach(function(b) {
                    b.classList.toggle('active', b.dataset.page == idx);
                });
            }

            btns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    aller(parseInt(btn.dataset.page, 10));
                });
            });
        });

        // ---------- Lecture des vidéos (l'iframe n'est chargée qu'au clic) ----------
        function jouerVideo(btn) {
            var frame = btn.closest('.gal-vframe');
            var embed = frame.querySelector('.gal-vembed');
            var iframe = embed.querySelector('iframe');
            iframe.src = iframe.dataset.src;
            embed.style.display = 'block';
            btn.style.display = 'none';
            var thumb = frame.querySelector('.gal-vthumb');
            if (thumb) thumb.style.display = 'none';
        }
    </script>

    @if ($photos->isNotEmpty())
        <div id="galerieLightbox" class="galerie-lightbox" role="dialog" aria-modal="true" aria-label="Aperçu de la photo">
            <button type="button" class="galerie-lb-close" onclick="fermerGalerie()" aria-label="Fermer">&times;</button>
            <button type="button" class="galerie-lb-nav galerie-lb-prev" onclick="galeriePrecedente()" aria-label="Photo précédente">&#10094;</button>

            <div class="galerie-lb-card">
                <img id="galerieLbImg" src="" alt="">
                <div class="galerie-lb-body">
                    <div>
                        <h3 id="galerieLbTitre"></h3>
                        <p id="galerieLbDesc"></p>
                    </div>
                    <span class="galerie-lb-count" id="galerieLbCount"></span>
                </div>
            </div>

            <button type="button" class="galerie-lb-nav galerie-lb-next" onclick="galerieSuivante()" aria-label="Photo suivante">&#10095;</button>
        </div>
    @endif

@endpush