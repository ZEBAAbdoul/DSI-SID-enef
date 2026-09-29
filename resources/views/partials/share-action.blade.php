{{-- 
    Partage d'une actualité (défini une seule fois par page).

    Utilise l'API Web Share natif (mobile / desktop compatible) quand elle existe,
    sinon copie le lien dans le presse-papiers avec retour visuel « Lien copié ! ».
    Le bouton doit porter l'attribut data-partage (et data-titre / data-url).
--}}
<script>
    (function () {
        if (window.partagerActualite) return;

        // Copie de secours : contextes non sécurisés ou sans Clipboard API
        function copieSecours(texte) {
            var zone = document.createElement('textarea');
            zone.value = texte;
            zone.setAttribute('readonly', '');
            zone.style.position = 'fixed';
            zone.style.top = '-9999px';
            zone.style.opacity = '0';
            document.body.appendChild(zone);
            zone.select();
            try {
                document.execCommand('copy');
            } catch (e) {}
            document.body.removeChild(zone);
        }

        function copierLien(url, btn) {
            function retroaction() {
                if (!btn) return;
                var original = btn.innerHTML;
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="width:15px;height:15px;"><path d="M20 6L9 17l-5-5" /></svg> Lien copié !';
                setTimeout(function () {
                    if (btn.innerHTML.indexOf('Lien copié') !== -1) {
                        btn.innerHTML = original;
                    }
                }, 2200);
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(retroaction, function () {
                    copieSecours(url);
                    retroaction();
                });
            } else {
                copieSecours(url);
                retroaction();
            }
        }

        window.partagerActualite = function (titre, url, btn) {
            if (navigator.share) {
                // URL envoyée une seule fois, via le champ standard « url »
                // (l'app destinataire construit elle-même le lien partageable).
                navigator.share({ title: titre, text: titre, url: url })['catch'](function () {});
            } else {
                copierLien(url, btn);
            }
        };

        // Délégation d'événement : fonctionne pour tous les boutons [data-partage]
        document.addEventListener('click', function (e) {
            var btn = e.target && e.target.closest ? e.target.closest('[data-partage]') : null;
            if (!btn) return;
            partagerActualite(
                btn.getAttribute('data-titre') || document.title,
                btn.getAttribute('data-url') || location.href,
                btn
            );
        });
    })();
</script>