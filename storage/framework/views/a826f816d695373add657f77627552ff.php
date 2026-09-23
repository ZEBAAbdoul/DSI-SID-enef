
<?php
    $ri = $rechercheInnovation ?? null;
?>


<div class="col-md-8">

    <label class="form-label fw-bold">
        Titre *
    </label>

    <input
        type="text"
        name="titre"
        class="form-control"
        value="<?php echo e(old('titre', $ri?->titre ?? '')); ?>"
        required
    >

</div>



<div class="col-md-4">

    <label class="form-label fw-bold">
        Type *
    </label>

    <select name="type" class="form-select" required>

        <option value="recherche" <?php if(old('type', $ri?->type ?? '') === 'recherche'): echo 'selected'; endif; ?>>
            Recherche
        </option>

        <option value="innovation" <?php if(old('type', $ri?->type ?? '') === 'innovation'): echo 'selected'; endif; ?>>
            Innovation
        </option>

    </select>

</div>



<div class="col-12">

    <label class="form-label fw-bold">
        Chapo
    </label>

    <textarea
        name="chapo"
        rows="3"
        class="form-control"
        maxlength="1000"
    ><?php echo e(old('chapo', $ri?->chapo ?? '')); ?></textarea>

    <small class="text-muted">
        Résumé court de la recherche ou de l'innovation.
    </small>

</div>



<div class="col-12">

    <label class="form-label fw-bold">
        Contenu *
    </label>

    <textarea
        name="contenu"
        rows="12"
        class="form-control"
        required
    ><?php echo e(old('contenu', $ri?->contenu ?? '')); ?></textarea>

</div>



<div class="col-md-8">

    <label class="form-label fw-bold d-block">
        Photos
    </label>

    <div id="photos-widget">

        
        <?php if($ri?->photo_list): ?>
            <div class="mb-2">
                <?php $__currentLoopData = $ri->photo_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $chemin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="photos-photo-physique d-flex align-items-center gap-2 border rounded p-2 mb-2"
                         data-chemin="<?php echo e($chemin); ?>">

                        <img src="<?php echo e(asset('storage/' . $chemin)); ?>"
                             alt="Photo <?php echo e($index + 1); ?> de <?php echo e($ri->titre); ?>"
                             style="width:56px; height:42px; object-fit:cover; border-radius:4px; flex-shrink:0;">
                        <div class="flex-grow-1">
                            <div class="small fw-semibold">
                                Photo <?php echo e($index + 1); ?>

                            </div>
                            <div class="small text-muted photos-statut">
                                Cliquer sur − pour retirer
                            </div>
                        </div>

                        <input type="hidden" name="photos_actuelles[]" value="<?php echo e($chemin); ?>">

                        <button type="button"
                                class="btn btn-sm btn-outline-danger photos-basculer"
                                title="Retirer cette photo"
                                aria-label="Retirer cette photo">−</button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        
        <div id="photos-nouvelles" class="d-flex flex-column gap-2 mb-2"></div>

        
        <button type="button" id="photos-ajouter" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-plus me-1"></i>
            Ajouter une photo
        </button>

    </div>

    <small class="text-muted d-block mt-1">
        Utilisez <strong>+</strong> pour ajouter une photo et <strong>−</strong> pour la retirer. Le bouton − sert aussi à retirer une photo déjà enregistrée (recliquez sur + pour annuler).
        JPG, PNG ou WEBP — 2 Mo maximum par photo. La première photo sert de couverture.
    </small>

</div>



<div class="col-md-4">

    <label class="form-label fw-bold d-block">
        Publication
    </label>

    <div class="form-check form-switch mt-2">
        <input
            type="checkbox"
            name="is_publiee"
            value="1"
            class="form-check-input"
            id="is_publiee"
            <?php if(old('is_publiee', $ri?->is_publiee ?? true)): echo 'checked'; endif; ?>
        >
        <label class="form-check-label" for="is_publiee">
            Publier immédiatement
        </label>
    </div>

    <small class="text-muted">
        Décochez pour enregistrer en brouillon.
    </small>

</div>



<div class="col-md-6">

    <label class="form-label fw-bold d-block">
        URL vidéo
    </label>

    <input
        type="url"
        name="url_video"
        class="form-control"
        value="<?php echo e(old('url_video', $ri?->url_video ?? '')); ?>"
        placeholder="https://www.youtube.com/watch?v=..."
    >

    <small class="text-muted">
        YouTube, Vimeo ou Dailymotion.
    </small>

</div>



<div class="col-md-6">

    <label class="form-label fw-bold d-block">
        Document joint
    </label>

    <?php if($ri?->document): ?>
        <a
            href="<?php echo e(asset($ri->document)); ?>"
            target="_blank"
            rel="noopener"
            class="d-block mb-2 text-truncate"
            style="max-width:100%;"
        >
            <i class="fas fa-file-pdf me-1 text-danger"></i>
            <?php echo e($ri->document_nom); ?>

        </a>
        <small class="text-muted d-block mb-2">
            Document actuel
        </small>
    <?php endif; ?>

    <input
        type="file"
        name="document"
        class="form-control"
        accept=".pdf,.doc,.docx"
    >

    <small class="text-muted">
        PDF, DOC ou DOCX — maximum 10 Mo.
    </small>

</div>


<script>
(function () {
    const conteneur = document.getElementById('photos-nouvelles');
    const boutonAjouter = document.getElementById('photos-ajouter');

    if (!conteneur || !boutonAjouter) {
        return;
    }

    function creerLignePhoto() {
        const ligne = document.createElement('div');
        ligne.className = 'photos-ligne d-flex align-items-center gap-2 border rounded p-2';

        // Zone d'aperçu
        const apercu = document.createElement('div');
        apercu.className = 'bg-light rounded d-flex align-items-center justify-content-center';
        apercu.style.cssText = 'width:56px;height:42px;flex-shrink:0;overflow:hidden;';
        const icone = document.createElement('i');
        icone.className = 'fas fa-image text-muted';
        apercu.appendChild(icone);

        // Champ fichier
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'photo[]';
        input.accept = '.jpg,.jpeg,.png,.webp';
        input.className = 'form-control form-control-sm';

        // Aperçu immédiat
        input.addEventListener('change', function () {
            apercu.innerHTML = '';
            const fichier = input.files && input.files[0];

            if (!fichier) {
                apercu.appendChild(icone);
                return;
            }

            const img = document.createElement('img');
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
            img.src = URL.createObjectURL(fichier);
            apercu.appendChild(img);
        });

        // Bouton − (retirer la ligne)
        const retirer = document.createElement('button');
        retirer.type = 'button';
        retirer.className = 'btn btn-sm btn-outline-danger photos-ligne-retirer';
        retirer.title = 'Retirer cette photo';
        retirer.setAttribute('aria-label', 'Retirer cette photo');
        retirer.textContent = '−';
        retirer.addEventListener('click', function () {
            ligne.remove();
        });

        ligne.appendChild(apercu);
        ligne.appendChild(input);
        ligne.appendChild(retirer);
        conteneur.appendChild(ligne);
    }

    // Bouton + : ajouter une ligne fichier
    boutonAjouter.addEventListener('click', creerLignePhoto);

    // Une ligne par défaut en création
    creerLignePhoto();

    // Basculer le retrait d'une photo déjà enregistrée (bouton − / +)
    document.querySelectorAll('.photos-basculer').forEach(function (bouton) {
        bouton.addEventListener('click', function () {
            const ligne = bouton.closest('.photos-photo-physique');
            if (!ligne) {
                return;
            }

            const chemin = ligne.dataset.chemin;
            const statut = ligne.querySelector('.photos-statut');
            const dejaCoche = Array.from(
                ligne.querySelectorAll('input[name="supprimer_photos[]"]')
            ).find(function (i) {
                return i.value === chemin;
            });

            if (dejaCoche) {
                // Annuler le retrait (repasse en +)
                dejaCoche.remove();
                ligne.classList.remove('opacity-50', 'border-danger');
                statut.textContent = 'Cliquer sur − pour retirer';
                bouton.classList.remove('btn-danger');
                bouton.classList.add('btn-outline-danger');
                bouton.textContent = '−';
                bouton.title = 'Retirer cette photo';
            } else {
                // Marquer la photo comme à retirer
                const champ = document.createElement('input');
                champ.type = 'hidden';
                champ.name = 'supprimer_photos[]';
                champ.value = chemin;
                ligne.appendChild(champ);

                ligne.classList.add('opacity-50', 'border-danger');
                statut.textContent = 'Retirée — cliquez sur + pour annuler';
                bouton.classList.remove('btn-outline-danger');
                bouton.classList.add('btn-danger');
                bouton.textContent = '+';
                bouton.title = 'Annuler le retrait';
            }
        });
    });
})();
</script><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\recherches_innovations\partials\form.blade.php ENDPATH**/ ?>