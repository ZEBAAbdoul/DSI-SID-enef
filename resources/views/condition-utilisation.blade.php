@extends('layouts.site')

@section('title', "Conditions d'utilisation — ENEF")

@section('content')

    <section style="padding:60px 0;">
        <div class="container">
            <div class="legal-page">

                <div class="eyebrow-line eyebrow-line--dark"><span class="rule"></span> Informations légales</div>
                <h1>Conditions d'utilisation</h1>
                <p class="legal-updated">Dernière mise à jour : {{ now()->translatedFormat('d F Y') }}</p>

                <div class="legal-body">

                    <h2>1. Objet</h2>
                    <p>
                        Les présentes conditions d'utilisation (« CGU ») régissent l'accès et l'utilisation de la
                        plateforme en ligne de l'École Nationale des Eaux et Forêts (« ENEF »), accessible à
                        l'adresse {{ url('/') }}, permettant notamment la création d'un compte candidat, le dépôt
                        d'un dossier de candidature et le suivi de son instruction. En créant un compte ou en
                        utilisant la plateforme, l'utilisateur reconnaît avoir lu, compris et accepté sans réserve
                        les présentes CGU.
                    </p>

                    <h2>2. Accès à la plateforme</h2>
                    <p>
                        La plateforme est accessible à toute personne souhaitant déposer une candidature nationale
                        ou internationale auprès de l'ENEF, sous réserve de disposer d'un accès à Internet.
                        L'ENEF met en œuvre les moyens raisonnables pour assurer un accès continu au service, sans
                        toutefois garantir une disponibilité ininterrompue et se réserve le droit de suspendre
                        l'accès pour des opérations de maintenance, de mise à jour ou pour tout autre motif
                        technique.
                    </p>

                    <h2>3. Création et gestion du compte</h2>
                    <p>
                        L'utilisateur s'engage à fournir des informations exactes, complètes et à jour lors de la
                        création de son compte et du dépôt de son dossier. Toute fausse déclaration, falsification
                        de document ou usurpation d'identité peut entraîner le rejet de la candidature, la
                        suppression du compte et, le cas échéant, des poursuites conformément à la législation en
                        vigueur.
                    </p>
                    <p>
                        L'utilisateur est seul responsable de la confidentialité de son mot de passe et de toute
                        activité effectuée depuis son compte. Il s'engage à informer immédiatement l'ENEF en cas de
                        perte, de vol ou d'utilisation non autorisée de son compte.
                    </p>

                    <h2>4. Dépôt et instruction des dossiers</h2>
                    <p>
                        Le dépôt d'un dossier via la plateforme ne vaut pas admission et ne préjuge en rien de la
                        décision finale de l'ENEF. Les pièces justificatives transmises doivent être authentiques,
                        lisibles et conformes aux formats demandés. L'ENEF se réserve le droit de demander toute
                        pièce complémentaire nécessaire à l'instruction du dossier.
                    </p>

                    <h2>5. Propriété intellectuelle</h2>
                    <p>
                        L'ensemble des contenus présents sur la plateforme (textes, logos, graphismes, mise en
                        page, logiciels) est la propriété exclusive de l'ENEF ou de ses partenaires, et est protégé
                        par la législation relative à la propriété intellectuelle. Toute reproduction, représentation
                        ou exploitation, totale ou partielle, sans autorisation préalable est interdite.
                    </p>

                    <h2>6. Responsabilité</h2>
                    <p>
                        L'ENEF met tout en œuvre pour assurer l'exactitude des informations diffusées sur la
                        plateforme, sans pouvoir garantir l'absence totale d'erreur ou d'omission. L'ENEF ne
                        saurait être tenue responsable des dommages directs ou indirects résultant de
                        l'utilisation de la plateforme, d'une interruption de service, d'une perte de données ou
                        d'un accès non autorisé résultant d'une négligence de l'utilisateur.
                    </p>

                    <h2>7. Modification des conditions</h2>
                    <p>
                        L'ENEF se réserve le droit de modifier à tout moment les présentes CGU. Les utilisateurs
                        seront informés de toute modification substantielle. La poursuite de l'utilisation de la
                        plateforme après une modification vaut acceptation des nouvelles conditions.
                    </p>

                    <h2>8. Droit applicable</h2>
                    <p>
                        Les présentes CGU sont soumises au droit burkinabè. Tout litige relatif à leur
                        interprétation ou à leur exécution relève de la compétence des juridictions compétentes du
                        Burkina Faso.
                    </p>

                    <h2>9. Contact</h2>
                    <p>
                        Pour toute question relative aux présentes conditions d'utilisation, vous pouvez contacter
                        l'ENEF via les coordonnées disponibles sur la page « Contact » du site.
                    </p>

                </div>

                <a href="{{ url()->previous() }}" class="btn btn-outline" style="margin-top:32px;">
                    ← Retour
                </a>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .legal-page {
            max-width: 780px;
            margin: 0 auto;
        }

        .legal-page h1 {
            font-size: 32px;
            margin: 14px 0 6px;
            color: var(--ink);
        }

        .legal-updated {
            color: var(--ink-soft);
            font-size: 13px;
            margin-bottom: 32px;
        }

        .legal-body h2 {
            font-size: 18px;
            color: var(--forest-deep);
            margin: 30px 0 10px;
        }

        .legal-body p {
            font-size: 14.5px;
            line-height: 1.7;
            color: var(--ink-soft);
            margin-bottom: 4px;
        }

        .eyebrow-line--dark {
            color: #000;
        }
    </style>
@endpush
