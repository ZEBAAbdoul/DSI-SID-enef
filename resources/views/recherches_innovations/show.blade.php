@extends('layouts.site')

@section('title', $rechercheInnovation->titre . ' — ENEF')

@section('content')

    <style>
        /* Page show : on bloque tout débordement horizontal.
               overflow-x: clip (et non hidden) pour ne pas casser le menu sticky. */
        html,
        body {
            overflow-x: clip;
        }

        /* ---------- Viewer photos (façon galerie) ---------- */
        .ri-media {
            margin-bottom: 28px;
        }

        .ri-media-main {
            position: relative;
            display: block;
            width: 100%;
            padding: 0;
            border: 1px solid var(--line);
            background: none;
            cursor: zoom-in;
        }

        .ri-media-main img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            display: block;
        }

        .ri-media-zoom {
            position: absolute;
            right: 12px;
            bottom: 12px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            background: rgba(10, 18, 13, .72);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            border-radius: 999px;
            pointer-events: none;
        }

        .ri-media-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .ri-media-thumb {
            padding: 2px;
            border: 2px solid transparent;
            background: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .ri-media-thumb:hover {
            border-color: var(--clay);
        }

        .ri-media-thumb.active {
            border-color: var(--water);
        }

        .ri-media-thumb img {
            width: 84px;
            height: 64px;
            object-fit: cover;
            display: block;
            border-radius: 1px;
        }

        /* ---------- Lightbox ---------- */
        .ri-lightbox {
            position: fixed;
            inset: 0;
            background: rgba(10, 18, 13, .95);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .ri-lightbox.open {
            display: flex;
        }

        .ri-lb-card {
            max-width: 960px;
            width: 100%;
            background: var(--white);
        }

        .ri-lb-card img {
            width: 100%;
            max-height: 76vh;
            object-fit: contain;
            background: #0b140f;
            display: block;
        }

        .ri-lb-body {
            padding: 14px 22px;
            display: flex;
            justify-content: flex-end;
        }

        .ri-lb-count {
            font-size: 13px;
            color: var(--ink-soft);
            white-space: nowrap;
        }

        .ri-lb-close {
            position: absolute;
            top: 18px;
            right: 22px;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            color: #fff;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            z-index: 1001;
        }

        .ri-lb-close:hover {
            background: rgba(255, 255, 255, .18);
        }

        .ri-lb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 46px;
            height: 46px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            z-index: 1001;
        }

        .ri-lb-nav:hover {
            background: rgba(255, 255, 255, .18);
        }

        .ri-lb-prev {
            left: 16px;
        }

        .ri-lb-next {
            right: 16px;
        }

        @media (max-width: 640px) {
            .ri-lightbox {
                padding: 16px;
            }

            .ri-lb-nav {
                width: 38px;
                height: 38px;
            }

            .ri-lb-prev {
                left: 6px;
            }

            .ri-lb-next {
                right: 6px;
            }
        }
    </style>

    <section style="padding:40px 0 60px;">
        <div class="container" style="max-width:800px;">

            <span class="kicker">{{ $rechercheInnovation->type_libelle }}</span>
            <h1 style="font-size:clamp(26px,3.5vw,38px);">{{ $rechercheInnovation->titre }}</h1>
            <p style="color:var(--ink-soft);font-size:14px;margin-bottom:24px;">
                Publié le {{ $rechercheInnovation->created_at?->translatedFormat('d F Y') }}
            </p>

            @php $photos = $rechercheInnovation->photos; @endphp

            @if ($photos)
                <div class="ri-media" id="ri-media">
                    <button type="button" class="ri-media-main" data-open="0" aria-label="Agrandir la première photo">
                        <img src="{{ $photos[0] }}" alt="{{ $rechercheInnovation->titre }} — photo principale">
                        <span class="ri-media-zoom">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="7" />
                                <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" />
                            </svg>
                            Agrandir
                        </span>
                    </button>

                    @if (count($photos) > 1)
                        <div class="ri-media-strip">
                            @foreach ($photos as $i => $photo)
                                <button type="button"
                                    class="ri-media-thumb @if ($i === 0) active @endif"
                                    data-open="{{ $i }}"
                                    aria-label="Afficher la photo {{ $i + 1 }} de {{ count($photos) }}">
                                    <img src="{{ $photo }}"
                                        alt="{{ $rechercheInnovation->titre }} — photo {{ $i + 1 }}" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Lightbox --}}
                <div id="riLightbox" class="ri-lightbox" role="dialog" aria-modal="true" aria-label="Galerie de photos">
                    <button type="button" class="ri-lb-close" id="riLbClose" aria-label="Fermer">&times;</button>
                    <button type="button" class="ri-lb-nav ri-lb-prev" id="riLbPrev"
                        aria-label="Photo précédente">&#10094;</button>
                    <button type="button" class="ri-lb-nav ri-lb-next" id="riLbNext"
                        aria-label="Photo suivante">&#10095;</button>
                    <div class="ri-lb-card">
                        <img id="riLbImg" src="" alt="">
                        <div class="ri-lb-body">
                            <span class="ri-lb-count" id="riLbCount"></span>
                        </div>
                    </div>
                </div>

                <script>
                    (function() {
                        var media = document.getElementById('ri-media');
                        if (!media) return;
                        var photos = @json($photos);
                        var index = 0;
                        var lib = document.getElementById('riLightbox');
                        var img = document.getElementById('riLbImg');
                        var count = document.getElementById('riLbCount');

                        function afficher() {
                            img.src = photos[index];
                            count.textContent = (index + 1) + ' / ' + photos.length;
                        }

                        function ouvrir(i) {
                            index = i;
                            afficher();
                            lib.classList.add('open');
                            document.body.style.overflow = 'hidden';
                        }

                        function fermer() {
                            lib.classList.remove('open');
                            document.body.style.overflow = '';
                        }

                        media.querySelectorAll('[data-open]').forEach(function(b) {
                            b.addEventListener('click', function() {
                                ouvrir(parseInt(b.getAttribute('data-open'), 10));
                            });
                        });

                        document.getElementById('riLbClose').addEventListener('click', fermer);

                        document.getElementById('riLbPrev').addEventListener('click', function() {
                            index = (index - 1 + photos.length) % photos.length;
                            afficher();
                        });

                        document.getElementById('riLbNext').addEventListener('click', function() {
                            index = (index + 1) % photos.length;
                            afficher();
                        });

                        lib.addEventListener('click', function(e) {
                            if (e.target === lib) fermer();
                        });

                        document.addEventListener('keydown', function(e) {
                            if (!lib.classList.contains('open')) return;
                            if (e.key === 'Escape') fermer();
                            else if (e.key === 'ArrowRight') {
                                index = (index + 1) % photos.length;
                                afficher();
                            } else if (e.key === 'ArrowLeft') {
                                index = (index - 1 + photos.length) % photos.length;
                                afficher();
                            }
                        });
                    })();
                </script>
            @endif

            @if ($rechercheInnovation->chapo)
                <p
                    style="font-size:18px; font-weight:600; color:var(--forest-deep); overflow-wrap:anywhere; word-break:break-word;">
                    {{ $rechercheInnovation->chapo }}</p>
            @endif

            <div
                style="white-space:pre-line; font-size:15.5px; line-height:1.7; overflow-wrap:anywhere; word-break:break-word;">
                {{ $rechercheInnovation->contenu }}
            </div>

            {{-- Média : vidéo intégrée ou lien externe --}}
            {{-- @if ($rechercheInnovation->embed_url)
                <div style="aspect-ratio:16/9; margin-top:32px; background:#0b140f; border:1px solid var(--line);"> <iframe
                        src="{{ $rechercheInnovation->embed_url }}" title="{{ $rechercheInnovation->titre }}"
                        style="width:100%; height:100%; border:0; display:block;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen loading="lazy"> </iframe> </div>
            @elseif ($rechercheInnovation->url_video)
                <a href="{{ $rechercheInnovation->url_video }}" target="_blank" rel="noopener noreferrer"
                    style="display:inline-flex; align-items:center; gap:8px; margin-top:32px; font-weight:700;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="display:inline-block; vertical-align:-2px;" aria-hidden="true">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Consulter le lien
                </a>
            @endif --}}
              @if ($rechercheInnovation->embed_url)
                <div style="aspect-ratio:16/9; margin-top:32px; background:#0b140f; border:1px solid var(--line);"> <iframe
                        src="{{ $rechercheInnovation->embed_url }}" title="{{ $rechercheInnovation->titre }}"
                        style="width:100%; height:100%; border:0; display:block;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen loading="lazy"> </iframe> </div>
            @endif

            @if ($rechercheInnovation->url_video)
                <a href="{{ $rechercheInnovation->url_video }}" target="_blank" rel="noopener noreferrer"
                    style="display:inline-flex; align-items:center; gap:8px; margin-top:20px; font-weight:700;">


                    <i class="fas fa-eye" style="font-size:18px;"></i>

                    Consulter le lien
                </a>
            @endif


            {{-- Document joint --}}
            @if ($rechercheInnovation->document)
                <div style="margin-top:32px; padding:18px 20px; background:var(--paper-alt); border:1px solid var(--line);">
                    <div style="font-size:13px; color:var(--ink-soft); margin-bottom:6px;">Document joint</div>
                    <a href="{{ asset($rechercheInnovation->document) }}" target="_blank" rel="noopener noreferrer"
                        style="font-weight:700; color:var(--forest-mid);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="display:inline-block; margin-right:6px; vertical-align:-2px;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6M12 18v-6M9 15l3 3 3-3" />
                        </svg>
                        {{ $rechercheInnovation->document_nom }}
                    </a>
                </div>
            @endif

            <div style="margin-top:36px;">
                <a href="{{ url('/') }}" class="btn btn-outline">Retour à l'accueil</a>
            </div>

        </div>
    </section>

@endsection
