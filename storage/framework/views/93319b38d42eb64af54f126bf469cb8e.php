

<style>
        /* Styles autonomes (préfixe enef-) : indépendants de la version de Bootstrap du layout */
        .enef-auth {
            position: relative;
            width: min(980px, 94vw);
            margin: 1.5rem auto;
            font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, Arial, sans-serif;
            animation: enef-in .6s ease-out both;
        }

        /* Fond de page doux */
        .enef-auth::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(180deg, #eef3ee 0%, #dde8df 100%);
        }

        .enef-card {
            display: flex;
            min-height: 580px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(20, 60, 30, .18);
        }

        /* ---------- Panneau institutionnel ---------- */
        .enef-aside {
            position: relative;
            flex: 0 0 42%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.25rem 2.25rem 1.5rem;
            color: #fff;
            overflow: hidden;
            background:
                radial-gradient(circle at 12% 8%, rgba(255, 255, 255, .13) 0, transparent 42%),
                radial-gradient(circle at 92% 88%, rgba(255, 255, 255, .10) 0, transparent 45%),
                linear-gradient(160deg, #1b5e20 0%, #2e7d32 55%, #388e3c 100%);
        }

        .enef-tree {
            position: absolute;
            right: -34px;
            bottom: -30px;
            font-size: 15rem;
            color: rgba(255, 255, 255, .07);
            pointer-events: none;
        }

        .enef-aside-content,
        .enef-aside-footer {
            position: relative;
            z-index: 1;
        }

        .enef-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #fff;
            text-decoration: none;
        }

        .enef-brand:hover {
            color: #fff;
            text-decoration: none;
        }

        .enef-logo {
            flex-shrink: 0;
            width: 76px;
            height: 76px;
            padding: 6px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .25);
        }

        .enef-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .enef-brand-name {
            display: block;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 2px;
            line-height: 1.1;
        }

        .enef-brand-sub {
            display: block;
            margin-top: .2rem;
            font-size: .8rem;
            opacity: .9;
            line-height: 1.3;
        }

        .enef-aside-body {
            margin-top: 2.5rem;
        }

        .enef-kicker {
            margin: 0 0 .5rem;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: .8;
        }

        .enef-headline {
            margin: 0 0 1.5rem;
            font-size: 1.35rem;
            font-weight: 600;
            line-height: 1.4;
            color: #fff;
        }

        .enef-features {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .enef-features li {
            display: flex;
            align-items: flex-start;
            gap: .8rem;
            margin-bottom: .95rem;
            font-size: .88rem;
            line-height: 1.45;
        }

        .enef-features i {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .16);
            font-size: .85rem;
        }

        .enef-aside-footer {
            margin: 1.5rem 0 0;
            font-size: .72rem;
            opacity: .75;
        }

        /* ---------- Formulaire ---------- */
        .enef-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 2.75rem;
            color: #1f2a22;
        }

        .enef-heading {
            margin-bottom: 1.5rem;
        }

        .enef-heading h1 {
            margin: 0 0 .25rem;
            font-size: 1.7rem;
            font-weight: 700;
            color: #1b5e20;
        }

        .enef-heading p {
            margin: 0;
            font-size: .92rem;
            color: #6b7a6f;
        }

        .enef-group {
            margin-bottom: 1.1rem;
        }

        .enef-label {
            display: block;
            margin-bottom: .4rem;
            font-size: .85rem;
            font-weight: 600;
            color: #2b3a2f;
        }

        .enef-field {
            position: relative;
        }

        .enef-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7a8a7d;
            pointer-events: none;
        }

        .enef-input {
            display: block;
            width: 100%;
            height: 48px;
            padding: 0 46px 0 43px;
            border: 1.5px solid #d5ddd6;
            border-radius: 10px;
            background: #f8faf8;
            font-size: .95rem;
            color: #1f2a22;
            transition: border-color .2s, box-shadow .2s, background-color .2s;
        }

        .enef-input::placeholder {
            color: #a3aea5;
        }

        .enef-input:focus {
            outline: none;
            border-color: #2e7d32;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(46, 125, 50, .15);
        }

        .enef-input.is-invalid {
            border-color: #c62828;
            background: #fff8f8;
        }

        .enef-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(198, 40, 40, .15);
        }

        .enef-toggle {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #7a8a7d;
            cursor: pointer;
            transition: color .2s, background-color .2s;
        }

        .enef-toggle:hover,
        .enef-toggle:focus-visible {
            color: #2e7d32;
            background: rgba(46, 125, 50, .09);
            outline: none;
        }

        .enef-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
            margin: .25rem 0 1.4rem;
            font-size: .86rem;
        }

        .enef-check {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin: 0;
            font-weight: 500;
            color: #3d4b41;
            cursor: pointer;
        }

        .enef-check input {
            width: 17px;
            height: 17px;
            margin: 0;
            accent-color: #2e7d32;
        }

        .enef-forgot {
            font-weight: 600;
            color: #2e7d32;
            text-decoration: none;
        }

        .enef-forgot:hover {
            color: #1b5e20;
            text-decoration: underline;
        }

        .enef-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #2e7d32, #3f9443);
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: .3px;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(46, 125, 50, .30);
            transition: transform .15s, box-shadow .2s, opacity .2s;
        }

        .enef-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(46, 125, 50, .38);
        }

        .enef-btn:focus-visible {
            outline: 3px solid rgba(46, 125, 50, .35);
            outline-offset: 2px;
        }

        .enef-btn:disabled {
            opacity: .8;
            cursor: wait;
            transform: none;
        }

        .enef-spinner {
            display: none;
            width: 17px;
            height: 17px;
            border: 2px solid rgba(255, 255, 255, .45);
            border-top-color: #fff;
            border-radius: 50%;
            animation: enef-spin .7s linear infinite;
        }

        /* ---------- Séparateur + liens ---------- */
        .enef-divider {
            display: flex;
            align-items: center;
            gap: .8rem;
            margin: 1.6rem 0 1rem;
            font-size: .8rem;
            color: #8a978d;
        }

        .enef-divider::before,
        .enef-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e1e7e2;
        }

        .enef-links {
            display: flex;
            gap: .7rem;
        }

        .enef-link {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .65rem .5rem;
            border: 1.5px solid #d5ddd6;
            border-radius: 10px;
            font-size: .86rem;
            font-weight: 600;
            color: #3d4b41;
            text-decoration: none;
            transition: border-color .2s, color .2s, background-color .2s;
        }

        .enef-link:hover {
            border-color: #9db8a0;
            background: #f4f8f4;
            color: #1b5e20;
            text-decoration: none;
        }

        .enef-link--primary {
            border-color: #2e7d32;
            color: #2e7d32;
        }

        .enef-link--primary:hover {
            background: #2e7d32;
            border-color: #2e7d32;
            color: #fff;
        }

        .enef-security {
            margin: 1.4rem 0 0;
            text-align: center;
            font-size: .75rem;
            color: #8a978d;
        }

        .enef-security i {
            margin-right: .3rem;
        }

        /* ---------- Alertes ---------- */
        .enef-alert {
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            margin-bottom: 1.1rem;
            padding: .85rem 1rem;
            border: 1px solid;
            border-radius: 10px;
            font-size: .88rem;
            line-height: 1.45;
        }

        .enef-alert i {
            margin-top: .15rem;
        }

        .enef-alert--danger {
            background: #fdecea;
            border-color: #f5c2c0;
            color: #8a1c1c;
        }

        .enef-alert--success {
            background: #eaf6ec;
            border-color: #b9dfbf;
            color: #1e5b26;
        }

        .enef-alert--info {
            background: #e8f3fb;
            border-color: #b6d8f0;
            color: #1b4f72;
        }

        /* ---------- En-tête avec pictogramme (pages secondaires) ---------- */
        .enef-badge-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            margin-bottom: 1rem;
            border-radius: 14px;
            background: #eaf6ec;
            color: #2e7d32;
            font-size: 1.35rem;
        }

        .enef-lead {
            line-height: 1.55;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 767px) {
            .enef-card {
                flex-direction: column;
                min-height: 0;
            }

            .enef-aside {
                flex: none;
                padding: 1.4rem 1.5rem;
            }

            .enef-aside-body,
            .enef-aside-footer,
            .enef-tree {
                display: none;
            }

            .enef-logo {
                width: 58px;
                height: 58px;
            }

            .enef-main {
                padding: 1.75rem 1.5rem;
            }

            .enef-links {
                flex-direction: column;
            }
        }

        /* ---------- Animations ---------- */
        @keyframes enef-in {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: none; }
        }

        @keyframes enef-spin {
            to { transform: rotate(360deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .enef-auth,
            .enef-btn,
            .enef-spinner {
                animation: none !important;
                transition: none !important;
            }
        }
</style><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/auth/partials/enef-styles.blade.php ENDPATH**/ ?>