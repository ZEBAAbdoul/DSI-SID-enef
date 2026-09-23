<dialog id="testi-dialog" class="testi-dialog" aria-label="Témoignage complet">
    <div class="testi-dialog-inner">
        <button type="button" class="testi-dialog-close" aria-label="Fermer">×</button>
        <div class="testi-dialog-body"></div>
    </div>
</dialog>

<?php $__env->startPush('styles'); ?>
    <style>
        .testi-dialog {
            border: 0;
            padding: 0;
            width: min(560px, calc(100vw - 32px));
            max-height: calc(100vh - 48px);
            background: var(--white);
            color: var(--ink);
            border-top: 3px solid var(--forest-accent);
            box-shadow: 0 24px 60px rgba(0, 0, 0, .28);
        }

        .testi-dialog::backdrop {
            background: rgba(10, 25, 15, .55);
        }

        .testi-dialog-inner {
            position: relative;
            padding: 32px 30px 26px;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
        }

        .testi-dialog-close {
            position: absolute;
            top: 8px;
            right: 12px;
            width: 34px;
            height: 34px;
            border: 0;
            background: none;
            font-size: 28px;
            line-height: 1;
            color: var(--ink-soft);
            cursor: pointer;
        }

        .testi-dialog-close:hover {
            color: var(--ink);
        }

        /* Dans la fenêtre : texte complet, sans coupure */
        .testi-dialog .testi-text {
            display: block;
            -webkit-line-clamp: unset;
            overflow: visible;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .testi-dialog .testi-formation {
            display: inline-block;
            margin-bottom: 18px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function() {
            var dialog = document.getElementById('testi-dialog');
            if (!dialog || typeof dialog.showModal !== 'function') return;

            var body = dialog.querySelector('.testi-dialog-body');

            // Affiche « Lire la suite » uniquement sur les cartes dont le texte est coupé
            function refresh() {
                document.querySelectorAll('.testi-card').forEach(function(card) {
                    var text = card.querySelector('.testi-text');
                    var more = card.querySelector('.testi-more');
                    if (!text || !more) return;
                    more.hidden = !(text.scrollHeight > text.clientHeight + 1);
                });
            }

            document.addEventListener('click', function(e) {
                var btn = e.target.closest('.testi-more');
                if (!btn) return;

                var card = btn.closest('.testi-card');
                body.innerHTML = '';
                ['.testi-stars', '.testi-text', '.testi-formation', '.testi-who'].forEach(function(sel) {
                    var el = card.querySelector(sel);
                    if (el) body.appendChild(el.cloneNode(true));
                });
                dialog.showModal();
            });

            dialog.querySelector('.testi-dialog-close').addEventListener('click', function() {
                dialog.close();
            });

            // Clic sur le fond sombre = fermeture
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) dialog.close();
            });

            window.addEventListener('load', refresh);
            window.addEventListener('resize', refresh);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(refresh);
            refresh();
        })();
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/partials/testimonial-dialog.blade.php ENDPATH**/ ?>