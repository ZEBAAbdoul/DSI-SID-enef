<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ENEF — École Nationale des Eaux et Forêts')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,340;0,9..144,460;0,9..144,560;0,9..144,680;1,9..144,460&family=Public+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --forest-deep: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #3f9443 100%);
            --forest-mid: #504028;
            --forest-accent: #4c7a45;
            --leaf: #7fa66b;
            --water: #2c6c85;
            --water-soft: #e4eef1;
            --clay: #a15a2a;
            --clay-soft: #f1e2d2;
            --paper: #f3efe2;
            --paper-alt: #eae3cf;
            --ink: #1b241d;
            --ink-soft: #54604f;
            --line: #d9d2b9;
            --white: #fffdf7;
            --radius: 3px;
            --shadow: 0 14px 30px -18px rgba(15, 30, 20, .35);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Public Sans", system-ui, sans-serif;
            background: var(--paper);
            color: var(--ink);
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: "Fraunces", serif;
            font-weight: 560;
            color: var(--forest-deep);
            margin: 0 0 .5em;
            letter-spacing: -.01em;
        }

        p {
            margin: 0 0 1em;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 28px;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        :focus-visible {
            outline: 3px solid var(--water);
            outline-offset: 2px;
        }

        /* ---------- Skip link ---------- */
        .skip-link {
            position: absolute;
            left: -999px;
            top: 0;
            background: var(--forest-deep);
            color: #fff;
            padding: 10px 18px;
            z-index: 999;
        }

        .skip-link:focus {
            left: 12px;
            top: 12px;
        }

        /* ---------- Top utility bar ---------- */
        /* .topbar {
            background: var(--forest-deep);
            color: #dfe8de;
            font-size: 13.5px;
        } */

        .topbar {
    background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #3f9443 100%);
    color: #e8f3e8;
    font-size: 13.5px;
}

        .topbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 8px;
            padding-bottom: 8px;
            gap: 16px;
            flex-wrap: wrap;
                background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #3f9443 100%);

        }

        .topbar-contacts {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .topbar-contacts a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            opacity: .92;
        }

        .topbar-contacts a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .topbar-social {
            display: flex;
            gap: 12px;
        }

        .topbar-social a {
            opacity: .85;
        }

        .topbar-social a:hover {
            opacity: 1;
        }

        .lang-switch {
            display: flex;
            gap: 4px;
            opacity: .9;
        }

        .lang-switch button {
            background: none;
            border: none;
            color: inherit;
            padding: 2px 5px;
            font-size: 13px;
        }

        .lang-switch button[aria-current="true"] {
            text-decoration: underline;
            font-weight: 700;
        }

        /* ---------- Main nav ---------- */
        .navwrap {
            background: var(--white);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 60;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: conic-gradient(from 210deg, var(--forest-accent), var(--water) 45%, var(--clay) 85%, var(--forest-accent));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: inset 0 0 0 3px var(--white), 0 0 0 1px var(--line);
        }

        .brand-mark span {
            color: #fff;
            font-family: "Fraunces", serif;
            font-weight: 680;
            font-size: 17px;
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-text .full {
            display: block;
            font-family: "Fraunces", serif;
            font-weight: 680;
            font-size: 16.5px;
            color: var(--forest-deep);
        }

        .brand-text .sub {
            display: block;
            font-size: 11.5px;
            color: var(--ink-soft);
            letter-spacing: .01em;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .menu>li {
            position: relative;
        }

        .menu>li>a,
        .menu>li>button.toplink {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 12px 13px;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            background: none;
            border: none;
        }

        .menu>li>a:hover,
        .menu>li>button.toplink:hover,
        .menu>li.open>button.toplink {
            color: var(--forest-mid);
        }

        .chev {
            width: 9px;
            height: 9px;
            flex-shrink: 0;
            transition: transform .15s;
        }

        .menu>li.open .chev {
            transform: rotate(180deg);
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 270px;
            background: var(--white);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            padding: 8px;
            display: none;
        }

        .menu>li.open .dropdown {
            display: block;
        }

        .dropdown a {
            display: block;
            padding: 10px 12px;
            font-size: 14.5px;
            color: var(--ink);
            border-radius: 2px;
        }

        .dropdown a:hover {
            background: var(--paper-alt);
            color: var(--forest-mid);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border: 1px solid var(--line);
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn:hover {
            border-color: var(--forest-mid);
        }

        .icon-btn svg {
            width: 17px;
            height: 17px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            font-size: 14.5px;
            font-weight: 700;
            border-radius: 2px;
            border: 1.5px solid transparent;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--clay);
            color: #fff;
        }

        .btn-primary:hover {
            background: #8a4a21;
        }

        .btn-outline {
            background: transparent;
            border-color: var(--forest-deep);
            color: var(--forest-deep);
        }

        .btn-outline:hover {
            background: var(--forest-deep);
            color: #fff;
        }

        .btn-ghost-light {
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .55);
            color: #fff;
        }

        .btn-ghost-light:hover {
            background: rgba(255, 255, 255, .2);
        }

        .btn-water {
            background: var(--water);
            color: #fff;
        }

        .btn-water:hover {
            background: #235870;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 13.5px;
        }

        .account-dd {
            position: relative;
        }

        .account-dd .dropdown {
            right: 0;
            left: auto;
            min-width: 210px;
        }

        .burger {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--line);
            background: var(--white);
            border-radius: 50%;
            align-items: center;
            justify-content: center;
        }

        .burger svg {
            width: 19px;
            height: 19px;
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            overflow: hidden;
            background: var(--forest-deep);
            color: #fff;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(600px 380px at 82% -10%, rgba(127, 166, 107, .35), transparent 60%),
                radial-gradient(700px 500px at 100% 100%, rgba(44, 108, 133, .35), transparent 55%);
        }

        .hero-grid {
            position: relative;
            display: grid;
            grid-template-columns: .95fr 1.25fr;
            gap: 56px;
            padding: 76px 0 60px;
            align-items: center;
        }

        .eyebrow-line {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: #c9dcc4;
            font-size: 13.5px;
            font-weight: 600;
        }

        .eyebrow-line .rule {
            width: 34px;
            height: 2px;
            background: var(--leaf);
        }

        .hero h1 {
            color: #fff;
            font-size: clamp(34px, 4.4vw, 54px);
            line-height: 1.06;
            font-weight: 560;
            max-width: 16ch;
        }

        .hero-lede {
            color: #dbe6d8;
            font-size: 17.5px;
            max-width: 46ch;
            margin-bottom: 30px;
        }

        .hero-ctas {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 46px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, auto);
            gap: 34px;
            border-top: 1px solid rgba(255, 255, 255, .22);
            padding-top: 26px;
            max-width: 560px;
        }

        .hero-stats .num {
            font-family: "Fraunces", serif;
            font-size: 30px;
            color: #fff;
            font-weight: 560;
            display: block;
        }

        .hero-stats .lbl {
            font-size: 12.5px;
            color: #c3d4bf;
        }

        .hero-side {
            position: relative;
            background: linear-gradient(165deg, #254a34, #153a49);
            border: 1px solid rgba(255, 255, 255, .18);
            padding: 46px 40px;
            min-height: 460px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
        }

        .hero-side img.hero-side-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(21, 42, 32, .55) 0%, rgba(15, 30, 22, .92) 100%);
            z-index: 1;
        }

        .hero-side>* {
            position: relative;
            z-index: 2;
        }

        .hero-side .tag {
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: .04em;
            color: var(--leaf);
            text-transform: uppercase;
        }

        .hero-side h3 {
            color: #fff;
            font-size: 29px;
            line-height: 1.18;
            margin: 14px 0 16px;
            max-width: 22ch;
        }

        .hero-side p {
            color: #d9e4d6;
            font-size: 16px;
            max-width: 40ch;
            margin-bottom: 22px;
        }

        /* ---------- Hero-side : animation d'entrée + Ken Burns + shine ---------- */
        .hero-side {
            isolation: isolate;
        }

        /* Zoom lent et continu sur la photo de fond */
        .hero-side-photo {
            animation: heroKenBurns 16s ease-in-out infinite alternate;
            will-change: transform;
        }

        @keyframes heroKenBurns {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.09);
            }
        }

        /* Sweep lumineux diagonal qui traverse la carte au chargement puis au survol */
        .hero-side::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            background: linear-gradient(115deg,
                    transparent 40%,
                    rgba(255, 255, 255, .16) 50%,
                    transparent 60%);
            background-size: 220% 220%;
            background-position: 120% 0;
            animation: heroShine 5s ease-in-out .6s 1;
        }

        .hero-side:hover::after {
            animation: heroShine 1.4s ease-in-out;
        }

        @keyframes heroShine {
            from {
                background-position: 130% 0;
            }

            to {
                background-position: -30% 0;
            }
        }

        /* Cascade d'apparition du contenu texte, dans l'ordre : tag → titre → texte → bouton */
        .hero-side .tag,
        .hero-side h3,
        .hero-side p,
        .hero-side .btn {
            opacity: 0;
            transform: translateY(18px);
            animation: heroFadeUp .7s cubic-bezier(.19, 1, .22, 1) forwards;
        }

        .hero-side .tag {
            animation-delay: .15s;
        }

        .hero-side h3 {
            animation-delay: .32s;
        }

        .hero-side p {
            animation-delay: .5s;
        }

        .hero-side .btn {
            animation-delay: .68s;
        }

        @keyframes heroFadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Petit repère animé devant "Actualité à la une" */
        .hero-side .tag {
            position: relative;
            padding-left: 18px;
        }

        .hero-side .tag::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--leaf);
            transform: translateY(-50%);
            box-shadow: 0 0 0 0 rgba(127, 166, 107, .55);
            animation: heroPulse 2.2s ease-out infinite;
        }

        @keyframes heroPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(127, 166, 107, .55);
            }

            70% {
                box-shadow: 0 0 0 9px rgba(127, 166, 107, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(127, 166, 107, 0);
            }
        }

        /* Légère élévation de la carte au survol, cohérente avec le reste du site */
        .hero-side {
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .hero-side:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -20px rgba(0, 0, 0, .45);
        }

        @media (prefers-reduced-motion: reduce) {

            .hero-side-photo,
            .hero-side::after,
            .hero-side .tag,
            .hero-side h3,
            .hero-side p,
            .hero-side .btn,
            .hero-side .tag::before {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        .dg-photo-round {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clay), var(--water));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: "Fraunces", serif;
            font-weight: 680;
            font-size: 20px;
            margin-bottom: 14px;
        }

        /* ---------- Marquee témoignage ---------- */
        .marquee-strip {
            background: var(--clay-soft);
            border-bottom: 1px solid var(--line);
            overflow: hidden;
        }

        .marquee-track {
            display: flex;
            gap: 60px;
            padding: 11px 0;
            white-space: nowrap;
            animation: scroll 32s linear infinite;
            width: max-content;
        }

        .marquee-track span {
            font-size: 13.5px;
            color: #5c3c1f;
            font-weight: 600;
        }

        .marquee-track span b {
            color: var(--clay);
        }

        @keyframes scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .marquee-track {
                animation: none;
            }
        }

        /* ---------- Sections generic ---------- */
        section {
            padding: 76px 0;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 24px;
            margin-bottom: 38px;
            flex-wrap: wrap;
        }

        .section-head .kicker {
            color: var(--water);
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 8px;
            display: block;
        }

        .section-head h2 {
            font-size: clamp(24px, 3vw, 33px);
            max-width: 20ch;
        }

        .section-head p.desc {
            color: var(--ink-soft);
            max-width: 52ch;
            margin: 8px 0 0;
        }

        .alt {
            background: var(--white);
        }

        /* Mot du DG */
        .dg-section {
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            gap: 52px;
            align-items: center;
        }

        .dg-portrait {
            aspect-ratio: 4/5;
            background: linear-gradient(160deg, #2f5233, #1b3b2d);
            display: flex;
            align-items: flex-end;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .dg-portrait img.dg-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        .dg-portrait::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(23, 50, 38, 0) 45%, rgba(15, 30, 22, .85) 100%);
            z-index: 1;
        }

        .dg-portrait .cap {
            position: relative;
            z-index: 2;
            color: #e7efe3;
            font-size: 13px;
        }

        .dg-portrait .cap b {
            display: block;
            font-family: "Fraunces", serif;
            font-size: 18px;
            color: #fff;
            font-weight: 560;
        }

        blockquote {
            font-family: "Fraunces", serif;
            font-size: 23px;
            line-height: 1.45;
            color: var(--forest-deep);
            font-weight: 460;
            font-style: italic;
            margin: 0 0 20px;
            border-left: 3px solid var(--leaf);
            padding-left: 22px;
        }

        .dg-signoff {
            font-size: 14px;
            color: var(--ink-soft);
        }

        .dg-signoff b {
            color: var(--ink);
            display: block;
            font-size: 15px;
        }

        /* Actualités */
        .news-scroll-row {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .news-scroll-row .btn {
            flex-shrink: 0;
        }

        .news-marquee {
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        @media (max-width: 640px) {
            .news-marquee {
                flex-basis: 100%;
            }
        }

        .news-track {
            display: flex;
            gap: 26px;
            width: max-content;
            animation: newsScroll 36s linear infinite;
        }

        .news-marquee:hover .news-track {
            animation-play-state: paused;
        }

        @keyframes newsScroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .news-track {
                animation: none;
                flex-wrap: wrap;
                width: 100%;
            }
        }

        .news-batch {
            display: none;
        }

        .news-card {
            background: var(--white);
            border: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            width: 320px;
            flex-shrink: 0;
        }

        .news-thumb {
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, var(--water), #173226);
            position: relative;
            overflow: hidden;
        }

        .news-thumb img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .news-thumb .date {
            position: absolute;
            left: 14px;
            bottom: -16px;
            background: var(--clay);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 11px;
        }

        .news-body {
            padding: 26px 20px 22px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .news-cat {
            color: var(--water);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            margin-bottom: 8px;
        }

        .news-body h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .news-body p {
            color: var(--ink-soft);
            font-size: 14.5px;
            flex: 1;
        }

        .news-link {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--forest-mid);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .news-link svg {
            width: 13px;
            height: 13px;
        }

        /* Admissions steps */
        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            position: relative;
        }

        .step {
            padding: 0 22px 0 0;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 23px;
            left: calc(46px + 4px);
            right: 0;
            height: 1px;
            background: var(--line);
        }

        .step-num {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--forest-deep);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Fraunces", serif;
            font-weight: 680;
            font-size: 17px;
            position: relative;
            z-index: 1;
            margin-bottom: 18px;
        }

        .step h4 {
            font-size: 16.5px;
            margin-bottom: 8px;
        }

        .step p {
            font-size: 14px;
            color: var(--ink-soft);
            margin-bottom: 0;
        }

        .step .status {
            display: inline-block;
            margin-top: 10px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 9px;
            background: var(--water-soft);
            color: var(--water);
        }

        .admissions-cta {
            margin-top: 44px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            background: var(--forest-deep);
            color: #fff;
            padding: 30px 34px;
        }

        .admissions-cta h3 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 6px;
        }

        .admissions-cta p {
            color: #cddbc9;
            font-size: 14.5px;
            margin: 0;
        }

        /* Catalogue */
        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 9px 18px;
            border: 1.5px solid var(--line);
            background: var(--white);
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink-soft);
            border-radius: 20px;
        }

        .tab-btn[aria-selected="true"] {
            background: var(--forest-deep);
            color: #fff;
            border-color: var(--forest-deep);
        }

        .filter-chips {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .chip {
            font-size: 12.5px;
            padding: 6px 13px;
            background: var(--paper-alt);
            color: var(--ink-soft);
            border-radius: 20px;
            border: 1px solid var(--line);
        }

        .chip:hover {
            border-color: var(--forest-mid);
            color: var(--forest-mid);
        }

        .chip.chip-active {
            background: var(--forest-deep);
            color: #fff;
            border-color: var(--forest-deep);
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .course-card {
            background: var(--white);
            border: 1px solid var(--line);
            padding: 24px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .course-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
        }

        .badge {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 9px;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        .badge.prog {
            background: var(--water-soft);
            color: var(--water);
        }

        .badge.carte {
            background: var(--clay-soft);
            color: var(--clay);
        }

        .course-card h4 {
            font-size: 17px;
            margin-bottom: 10px;
        }

        .course-card p.d {
            color: var(--ink-soft);
            font-size: 14px;
            margin-bottom: 16px;
            flex: 1;
        }

        .course-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 9px 16px;
            font-size: 12.5px;
            color: var(--ink-soft);
            border-top: 1px solid var(--line);
            padding-top: 14px;
            margin-bottom: 16px;
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .course-meta svg {
            width: 13px;
            height: 13px;
            color: var(--forest-mid);
            flex-shrink: 0;
        }

        .course-card .btn {
            width: 100%;
        }

        .catalog-more {
            text-align: center;
            margin-top: 36px;
        }

        /* Prestations */
        .presta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 26px;
        }

        .presta-card {
            border: 1px solid var(--line);
            padding: 28px;
            background: var(--paper);
            position: relative;
        }

        .presta-card .ic {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--forest-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .presta-card .ic svg {
            width: 21px;
            height: 21px;
            color: #fff;
        }

        .presta-card h4 {
            font-size: 17.5px;
            margin-bottom: 9px;
        }

        .presta-card p {
            font-size: 14px;
            color: var(--ink-soft);
            margin-bottom: 16px;
        }

        /* Bibliothèque */
        .biblio {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 52px;
            align-items: center;
        }

        .biblio-search {
            background: var(--white);
            border: 1px solid var(--line);
            padding: 30px;
        }

        .search-row {
            display: flex;
            gap: 0;
            border: 1.5px solid var(--forest-deep);
            margin-bottom: 18px;
        }

        .search-row input {
            flex: 1;
            border: none;
            padding: 13px 16px;
            font-size: 14.5px;
            font-family: inherit;
            background: transparent;
        }

        .search-row input:focus {
            outline: none;
        }

        .search-row button {
            background: var(--forest-deep);
            color: #fff;
            border: none;
            padding: 0 18px;
            display: flex;
            align-items: center;
        }

        .search-row button svg {
            width: 17px;
            height: 17px;
        }

        .biblio-cats {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-bottom: 20px;
        }

        .biblio-stats {
            display: flex;
            gap: 30px;
            border-top: 1px solid var(--line);
            padding-top: 18px;
        }

        .biblio-stats .num {
            font-family: "Fraunces", serif;
            font-size: 24px;
            color: var(--forest-deep);
            display: block;
            font-weight: 560;
        }

        .biblio-stats .lbl {
            font-size: 12px;
            color: var(--ink-soft);
        }

        /* Espaces utilisateurs */
        .profiles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .profile-card {
            border: 1px solid var(--line);
            background: var(--white);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .profile-card .top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .profile-card h4 {
            font-size: 16px;
            margin: 0;
        }

        .acct-flag {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            white-space: nowrap;
        }

        .acct-flag.yes {
            background: var(--water-soft);
            color: var(--water);
        }

        .acct-flag.no {
            background: var(--paper-alt);
            color: var(--ink-soft);
        }

        .profile-card p {
            font-size: 13.5px;
            color: var(--ink-soft);
            margin: 0;
            flex: 1;
        }

        .profile-card .btn {
            align-self: flex-start;
        }

        /* Partenaires */
        .partners-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            justify-content: space-between;
        }

        .partner-logo {
            flex: 1;
            min-width: 150px;
            height: 78px;
            border: 1px solid var(--line);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-soft);
            font-weight: 700;
            font-size: 13.5px;
            letter-spacing: .02em;
        }

        /* Chiffres clés band */
        .stats-band {
            background: var(--forest-deep);
            color: #fff;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }

        .stats-grid .num {
            font-family: "Fraunces", serif;
            font-size: 38px;
            color: #fff;
            font-weight: 560;
            display: block;
        }

        .stats-grid .lbl {
            font-size: 13px;
            color: #c3d4bf;
            margin-top: 6px;
        }

        /* Avis */
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .review-card {
            background: var(--white);
            border: 1px solid var(--line);
            padding: 24px;
        }

        .stars {
            color: var(--clay);
            font-size: 14px;
            margin-bottom: 12px;
            letter-spacing: 2px;
        }

        .review-card p {
            font-size: 14.5px;
            color: var(--ink);
            margin-bottom: 16px;
        }

        .review-who {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--forest-accent), var(--water));
            flex-shrink: 0;
        }

        .review-who .name {
            font-size: 13.5px;
            font-weight: 700;
            display: block;
        }

        .review-who .role {
            font-size: 12px;
            color: var(--ink-soft);
        }

        /* Newsletter / social CTA */
        .cta-band {
            background: linear-gradient(120deg, var(--forest-deep), #1e4331 60%, #173a4a);
            color: #fff;
        }

        .cta-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 32px;
            flex-wrap: wrap;
        }

        .cta-inner h2 {
            color: #fff;
            font-size: 26px;
            max-width: 18ch;
        }

        .cta-inner p {
            color: #cfe0cc;
            max-width: 42ch;
        }

        .newsletter-form {
            display: flex;
            gap: 0;
            max-width: 380px;
            border: 1.5px solid rgba(255, 255, 255, .5);
        }

        .newsletter-form input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 13px 15px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
        }

        .newsletter-form input::placeholder {
            color: #cfe0cc;
        }

        .newsletter-form input:focus {
            outline: none;
        }

        .cta-social {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .cta-social a {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cta-social svg {
            width: 16px;
            height: 16px;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #3f9443 100%);
            color: #c7d6c3;
            padding-top: 64px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr repeat(4, 1fr);
            gap: 32px;
            padding-bottom: 44px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .footer-brand p {
            font-size: 13.5px;
            color: #a9bda4;
            margin: 14px 0 18px;
            max-width: 32ch;
        }

        .footer-addr {
            font-size: 13px;
            color: #a9bda4;
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .footer-addr svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            margin-top: 2px;
            color: var(--leaf);
        }

        .footer-col h5 {
            color: #fff;
            font-family: "Fraunces", serif;
            font-weight: 560;
            font-size: 15px;
            margin-bottom: 16px;
        }

        .footer-col li {
            margin-bottom: 10px;
        }

        .footer-col a {
            font-size: 13.5px;
            color: #b7c8b2;
        }

        .footer-col a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            padding: 22px 0;
            font-size: 12.5px;
            color: #8ba086;
        }

        .footer-bottom a {
            color: #8ba086;
        }

        .footer-bottom a:hover {
            color: #fff;
        }

        .back-to-top {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width:980px) {

            .menu,
            .nav-actions .btn.btn-outline {
                display: none;
            }

            .burger {
                display: flex;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .dg-section {
                grid-template-columns: 1fr;
            }

            .news-grid,
            .courses-grid,
            .presta-grid,
            .reviews-grid,
            .profiles-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
                row-gap: 34px;
            }

            .step:nth-child(2)::after {
                display: none;
            }

            .biblio {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                row-gap: 26px;
            }
        }

        @media (max-width:640px) {
            .topbar .container {
                justify-content: center;
                text-align: center;
            }

            .topbar-contacts {
                justify-content: center;
            }

            .news-grid,
            .courses-grid,
            .presta-grid,
            .reviews-grid,
            .profiles-grid,
            .steps {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                grid-template-columns: 1fr 1fr;
            }

            .hero-side {
                min-height: 340px;
                padding: 32px 26px;
            }

            .news-card {
                width: 280px;
            }

            section {
                padding: 54px 0;
            }

            .admissions-cta,
            .cta-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Logo enef */
        .brand-mark {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo-enef {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
    </style>
    @stack('styles')
</head>

<body>
    <a class="skip-link" href="#main">Aller au contenu principal</a>

    <!-- ===================== TOP BAR ===================== -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-contacts">
                <a href="tel:+22620980689"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.79.66 2.65a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.43-1.27a2 2 0 0 1 2.11-.45c.86.32 1.75.54 2.65.66A2 2 0 0 1 22 16.92z" />
                    </svg> (00226) 20 98 06 89</a>
                <a href="mailto:infos@enef.gov.bf"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16v16H4z" />
                        <path d="M22 6l-10 7L2 6" />
                    </svg> infos@enef.gov.bf</a>
                <span style="display:inline-flex;align-items:center;gap:7px;opacity:.85;"><svg width="14"
                        height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg> 01 BP 1105, Dindéresso — Bobo-Dioulasso</span>
            </div>
            <div class="topbar-right">
                <div class="topbar-social">
                    <a href="https://www.facebook.com/enef2021" aria-label="Facebook"><svg width="15" height="15"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z" />
                        </svg></a>
                    <a href="#" aria-label="LinkedIn"><svg width="15" height="15" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M20.45 20.45h-3.56v-5.58c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.68H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45z" />
                        </svg></a>
                    <a href="#" aria-label="YouTube"><svg width="15" height="15" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M23 12s0-3.6-.46-5.3a2.9 2.9 0 0 0-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.54.5a2.9 2.9 0 0 0-2 2C1 8.4 1 12 1 12s0 3.6.46 5.3a2.9 2.9 0 0 0 2 2c1.64.5 8.54.5 8.54.5s6.9 0 8.54-.5a2.9 2.9 0 0 0 2-2C23 15.6 23 12 23 12z" />
                            <path d="M9.75 15.5v-7l6 3.5-6 3.5z" fill="#173226" />
                        </svg></a>
                </div>
                <div class="lang-switch">
                    {{-- <button type="button" aria-current="true">FR</button>/<button type="button">EN</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== MAIN NAV ===================== -->
    <div class="navwrap">
        <div class="container nav">
            <a href="{{ url('/') }}" class="brand"> <span class="brand-mark"> <img
                        src="{{ asset('images/logo.jpg') }}" alt="Logo ENEF" class="logo-enef"> </span> <span
                    class="brand-text"> <span class="full">ENEF</span> <span class="sub">École Nationale des Eaux
                        et Forêts</span>
                </span> </a>

            <ul class="menu" id="mainMenu">
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>
                    <button class="toplink" aria-expanded="false">L'ENEF <svg class="chev" viewBox="0 0 12 8"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 1l5 5 5-5" />
                        </svg></button>
                    <ul class="dropdown">
                        <li><a href="{{ url('/') }}#dg">Mot du Directeur Général</a></li>
                                                <li><a href="{{ url('/') }}#actualites">Actualités</a></li>
                        {{-- <li><a href="{{ url('/formations/informations-complementaires') }}">Conditions d'entrée à l'ENEF</a></li> --}}
                        {{-- <li><a href="{{ url('/') }}#presentation">Présentation &amp; historique</a></li> --}}
                        <li><a href="{{ route('unites-pedagogiques') }}">Unités pédagogiques</a></li>
                        <li><a href="{{ url('/') }}#partenaires">Nos partenaires</a></li>
                        <li><a href="{{ route('recherches-innovations.index') }}">Recherche &amp; innovation</a></li>
                        <li><a href="{{ route('galerie.index') }}">Galerie photo &amp; vidéo</a></li>

                    </ul>
                </li>

                <li>
                    <button class="toplink" aria-expanded="false">Formations <svg class="chev" viewBox="0 0 12 8"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 1l5 5 5-5" />
                        </svg></button>
                    <ul class="dropdown">
                        <li><a href="{{ url('/catalogue-formations-initiales') }}">Formations initiales</a></li>
                        <li><a href="{{ url('/catalogue-formations-continues') }}">Formations continues</a></li>
                        {{-- <li><a href="mailto:infos@enef.gov.bf?subject=Demande%20de%20formation%20%C3%A0%20la%20carte">Demande
                                de formation à la carte</a></li>  --}}
                    </ul>
                </li>

                <li>
                    <button class="toplink" aria-expanded="false">E-services <svg class="chev" viewBox="0 0 12 8"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 1l5 5 5-5" />
                        </svg></button>
                    <ul class="dropdown">
                        <li><a href="{{ route('bibliotheque.consultation') }}">Bibliothèque en ligne</a></li>
                        <li><a href="{{ route('bibliotheque.index') }}">Centre de téléchargement</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('actualites.index') }}#actualites">Actualités</a></li>
                <li><a href="{{ route('contact.index') }}">Contact</a></li>

            </ul>

            <div class="nav-actions">
                {{-- <button class="icon-btn" aria-label="Rechercher sur le site">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.3-4.3" />
                    </svg>
                </button> --}}
                <div class="account-dd">
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm toplink">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21c1.5-4.5 5-6 8-6s6.5 1.5 8 6" />
                        </svg>
                        Connexion
                    </a>

                    <ul class="dropdown">
                        <li><a href="#login">Se connecter</a></li>
                        <li><a href="#register">Créer un compte candidat</a></li>
                        <li><a href="#suivi">Suivre ma candidature</a></li>
                    </ul>
                </div>
                <a href="{{ url('/') }}#admissions" class="btn btn-primary btn-sm">Candidater en ligne</a>
                <button class="burger" id="burgerBtn" aria-label="Ouvrir le menu" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <main id="main">
        @yield('content')
    </main>

    <!-- ===================== FOOTER ===================== -->
    @php
        $liensUtilesFooter = \Illuminate\Support\Facades\Cache::remember(
            'site.liens_utiles',
            now()->addHours(1),
            fn () => optional(\App\Models\ParametresSite::first())->liens_utiles ?? []
        ) ?? [];
    @endphp
    <footer id="contact">
        <div class="container">
            <div class="footer-grid" style="grid-template-columns:1.4fr repeat({{ !empty($liensUtilesFooter) ? 5 : 4 }}, 1fr);">
                <div class="footer-brand">
                    <div class="brand" style="gap:10px;">
                        <a href="{{ url('/') }}" class="brand"> <span class="brand-mark"> <img
                                    src="{{ asset('images/logo.jpg') }}" alt="Logo ENEF" class="logo-enef"> </span>
                            <span class="brand-text"> <span class="full" style="color:#fff;">ENEF</span> <span class="sub" style="color:#fff;">École
                                    Nationale des Eaux
                                    et Forêts</span>
                            </span> </a>
                        {{-- <span class="brand-text"><span class="full" style="color:#fff;">ENEF</span><span
                                class="sub" style="color:#93a88e;">Eaux et Forêts</span></span> --}}
                    </div>
                    <p>École publique de formation aux métiers des eaux, des forêts et de l'environnement, au service de
                        la Nation depuis 1953.</p>
                    <div class="footer-addr"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> 01 BP 1105, Dindéresso — Bobo-Dioulasso, Burkina Faso</div>
                    <div class="footer-addr"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.79.66 2.65a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.43-1.27a2 2 0 0 1 2.11-.45c.86.32 1.75.54 2.65.66A2 2 0 0 1 22 16.92z" />
                        </svg> (00226) 20 98 06 89</div>
                </div>
                <div class="footer-col">
                    <h5>L'ENEF</h5>
                    <ul>
                        <li><a href="{{ url('/') }}#dg">Mot du Directeur Général</a></li>
                        {{-- <li><a href="{{ url('/') }}#actualites">Actualités</a></li> --}}
                        <li><a href="{{ url('/') }}#presentation">Présentation &amp; historique</a></li>
                        <li><a href="{{ url('/') }}#partenaires">Nos partenaires</a></li>
                        <li><a href="{{ route('recherches-innovations.index') }}">Recherche &amp; innovation</a></li>
                        <li><a href="{{ route('galerie.index') }}">Galerie photo &amp; vidéo</a></li>
                        <li><a href="{{ url('/') }}#actualites">Actualités</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Admissions</h5>
                    <ul>
                        <li><a href="{{ url('/') }}#admissions">Conditions d'accès</a></li>
                        <li><a href="#register">Candidature en ligne</a></li>
                        <li><a href="#suivi">Suivi de dossier</a></li>
                        <li><a href="{{ url('/') }}#admissions">Résultats</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Formations</h5>
                    <ul>
                        <li><a href="{{ url('/') }}#catalogue">Formations programmées</a></li>
                        <li><a href="{{ url('/') }}#catalogue">Formations à la carte</a></li>
                        <li><a href="{{ url('/') }}#prestations">Appui-conseil</a></li>
                        <li><a href="{{ url('/') }}#bibliotheque">Bibliothèque</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>E-services</h5>
                    <ul>
                        <li><a href="#login">Espace personnel</a></li>
                        <li><a href="#register">Créer un compte</a></li>
                        <li><a href="{{ url('/') }}#bibliotheque">Bibliothèque en ligne</a></li>
                        <li><a href="{{ route('contact.index') }}">Nous écrire</a></li>
                    </ul>
                </div>
                @if(!empty($liensUtilesFooter))
                    <div class="footer-col">
                        <h5>Liens utiles</h5>
                        <ul>
                            @foreach($liensUtilesFooter as $lien)
                                @if(!empty($lien['titre']) && !empty($lien['url']))
                                    <li>
                                        <a href="{{ $lien['url'] }}" target="_blank" rel="noopener">{{ $lien['titre'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} École Nationale des Eaux et Forêts (ENEF) — Burkina Faso. Tous droits réservés.</span>
                <div style="display:flex;align-items:center;gap:18px;">
                    <a href="{{ route('mentionLegale')}}">Mentions légales</a>
                    <a href="#">Protection des données</a>
                    <a href="#top" class="back-to-top" aria-label="Haut de page">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 19V5M5 12l7-7 7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Dropdown menus (desktop + mobile)
        document.querySelectorAll('.menu > li > button.toplink, .account-dd > button.toplink').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var li = btn.closest('li') || btn.closest('.account-dd');
                var wasOpen = li.classList.contains('open');
                document.querySelectorAll('.menu > li.open, .account-dd.open').forEach(function(el) {
                    el.classList.remove('open');
                });
                if (!wasOpen) {
                    li.classList.add('open');
                    btn.setAttribute('aria-expanded', 'true');
                } else {
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        });
        document.addEventListener('click', function() {
            document.querySelectorAll('.menu > li.open, .account-dd.open').forEach(function(el) {
                el.classList.remove('open');
            });
        });

        // Mobile burger toggle
        var burger = document.getElementById('burgerBtn');
        var menu = document.getElementById('mainMenu');
        burger.addEventListener('click', function() {
            var isOpen = menu.style.display === 'flex';
            if (isOpen) {
                menu.style.display = '';
                burger.setAttribute('aria-expanded', 'false');
            } else {
                menu.style.display = 'flex';
                menu.style.flexDirection = 'column';
                menu.style.position = 'absolute';
                menu.style.top = '100%';
                menu.style.left = '0';
                menu.style.right = '0';
                menu.style.background = '#fffdf7';
                menu.style.borderTop = '1px solid #d9d2b9';
                menu.style.padding = '10px 20px 20px';
                burger.setAttribute('aria-expanded', 'true');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
