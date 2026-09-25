<div class="form-group">

    <label for="titre">
        Titre
        <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="titre"
        id="titre"
        class="form-control @error('titre') is-invalid @enderror"
        value="{{ old('titre', $photo->titre ?? '') }}"
        placeholder="Ex : Cérémonie officielle"
        maxlength="255"
        required
        autofocus
    >

    @error('titre')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>


<div class="form-group">

    <label for="description">
        Description
    </label>

    <textarea
        name="description"
        id="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Description de la photo..."
    >{{ old('description', $photo->description ?? '') }}</textarea>

    @error('description')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>


{{-- ========================================================= --}}
{{-- IMAGE / ORDRE / VISIBILITÉ                                --}}
{{-- ========================================================= --}}

<div class="row">

    {{-- Image --}}
    <div class="col-md-4">

        <div class="form-group">

            <label for="image">
                Image

                @if (!isset($photo))
                    <span class="text-danger">*</span>
                @endif
            </label>

            <div class="custom-file">

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="custom-file-input @error('image') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    {{ !isset($photo) ? 'required' : '' }}
                >

                <label
                    class="custom-file-label"
                    for="image"
                    id="image-label"
                >
                    Choisir une image
                </label>

            </div>

            <small class="form-text text-muted">
                JPG, JPEG, PNG, GIF, WEBP — 5 Mo ou plus : la photo est
                compressée automatiquement avant l'envoi.
            </small>

            @error('image')
                <span class="text-danger d-block mt-1">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- Ordre d'affichage --}}
    <div class="col-md-4">

        <div class="form-group">

            <label for="ordre">
                Ordre d'affichage
            </label>

            <input
                type="number"
                name="ordre"
                id="ordre"
                class="form-control @error('ordre') is-invalid @enderror"
                value="{{ old(
                    'ordre',
                    isset($photo)
                        ? $photo->ordre
                        : ($prochainOrdre ?? 1)
                ) }}"
                min="0"
                max="32767"
            >

            @error('ordre')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- Visibilité --}}
    <div class="col-md-4">

        <div class="form-group">

            <label>
                Visibilité
            </label>

            <div class="custom-control custom-switch mt-2">

                <input
                    type="checkbox"
                    name="est_visible"
                    value="1"
                    class="custom-control-input"
                    id="est_visible"
                    {{ old(
                        'est_visible',
                        $photo->est_visible ?? true
                    ) ? 'checked' : '' }}
                >

                <label
                    class="custom-control-label"
                    for="est_visible"
                >
                    Photo visible
                </label>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- APERÇU DE LA NOUVELLE IMAGE                               --}}
{{-- ========================================================= --}}

<div
    id="image-preview-container"
    class="form-group"
    style="display: none;"
>

    <label>
        Aperçu
    </label>

    <div>

        <img
            id="image-preview"
            src="#"
            alt="Aperçu"
            class="img-thumbnail"
            style="
                max-width: 300px;
                max-height: 200px;
                object-fit: contain;
            "
        >

    </div>

</div>


{{-- ========================================================= --}}
{{-- IMAGE ACTUELLE                                            --}}
{{-- ========================================================= --}}

{{-- @if (isset($photo) && $photo->image_url)

    <div class="form-group">

        <label>
            Image actuelle
        </label>

        <div>

            <img
                src="{{ asset($photo->image_url) }}"
                alt="{{ $photo->titre }}"
                class="img-thumbnail"
                style="
                    max-width: 300px;
                    max-height: 200px;
                    object-fit: contain;
                "
            >

        </div>

    </div>

@endif --}}
@if (isset($photo) && $photo->image_url)

    <div class="form-group">

        <label>
            Image actuelle
        </label>

        <div>
            <img
                src="{{ asset($photo->image_url) }}"
                alt="{{ $photo->titre }}"
                class="img-thumbnail"
                style="
                    max-width: 300px;
                    max-height: 200px;
                    object-fit: contain;
                "
            >
        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- BOUTONS                                                    --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between mt-4">

    <a
        href="{{ route('admin.photos.index') }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Retour
    </a>


    <button
        type="submit"
        class="btn btn-primary"
    >

        <i class="fas fa-save mr-1"></i>

        {{ isset($photo)
            ? 'Enregistrer les modifications'
            : 'Ajouter la photo'
        }}

    </button>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT APERÇU IMAGE                                   --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const imageLabel = document.getElementById('image-label');
    const previewContainer = document.getElementById(
        'image-preview-container'
    );
    const preview = document.getElementById('image-preview');

    if (!imageInput) {
        return;
    }

    // Seuil de compression : 5 Mo
    const SEUIL_COMPRESSION = 5 * 1024 * 1024;

    // Plus grand côté conservé après compression
    const LARGEUR_MAX = 1920;

    function formatTaille(octets) {
        if (octets >= 1024 * 1024) {
            return (octets / (1024 * 1024)).toFixed(1) + ' Mo';
        }
        return Math.max(1, Math.round(octets / 1024)) + ' Ko';
    }

    /**
     * Compresse une image lourde via un canvas :
     * redimensionnée à 1920 px max puis ré-encodée (WebP si possible,
     * sinon JPEG ; PNG conservé s'il a pu avoir de la transparence
     * et que WebP n'est pas disponible).
     * Retourne une promesse { blob, ext } ou null (échec / GIF).
     */
    function compresserImage(fichier) {
        return new Promise(function (resolve) {

            // GIF animé : on ne touche pas (seul le 1er cadre serait gardé)
            if (fichier.type === 'image/gif') {
                resolve(null);
                return;
            }

            const image = new Image();
            const url = URL.createObjectURL(fichier);

            image.onload = function () {

                let largeur = image.naturalWidth;
                let hauteur = image.naturalHeight;

                if (!largeur || !hauteur) {
                    URL.revokeObjectURL(url);
                    resolve(null);
                    return;
                }

                if (Math.max(largeur, hauteur) > LARGEUR_MAX) {
                    const ratio = LARGEUR_MAX / Math.max(largeur, hauteur);
                    largeur = Math.round(largeur * ratio);
                    hauteur = Math.round(hauteur * ratio);
                }

                const canvas = document.createElement('canvas');
                canvas.width = largeur;
                canvas.height = hauteur;

                const contexte = canvas.getContext('2d');

                if (fichier.type === 'image/png') {
                    contexte.clearRect(0, 0, largeur, hauteur);
                }

                contexte.drawImage(image, 0, 0, largeur, hauteur);

                URL.revokeObjectURL(url);

                // Format cible : WebP si supporté, sinon PNG pour les
                // images avec transparence, sinon JPEG.
                const supportWebp =
                    canvas.toDataURL('image/webp', 0.8)
                        .indexOf('data:image/webp') === 0;

                let type;
                let ext;

                if (supportWebp) {
                    type = 'image/webp';
                    ext = 'webp';
                } else if (fichier.type === 'image/png') {
                    type = 'image/png';
                    ext = 'png';
                } else {
                    type = 'image/jpeg';
                    ext = 'jpg';
                }

                // Qualité décroissante jusqu'à être sous le seuil
                let qualite = 0.85;

                function essayer() {
                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            resolve(null);
                            return;
                        }
                        if (
                            blob.size > SEUIL_COMPRESSION &&
                            qualite > 0.5 &&
                            type !== 'image/png'
                        ) {
                            qualite -= 0.1;
                            essayer();
                            return;
                        }
                        resolve({ blob: blob, ext: ext });
                    }, type, qualite);
                }

                essayer();
            };

            image.onerror = function () {
                URL.revokeObjectURL(url);
                resolve(null);
            };

            image.src = url;
        });
    }

    imageInput.addEventListener('change', function (event) {

        const fichier = event.target.files[0];

        if (!fichier) {

            previewContainer.style.display = 'none';

            imageLabel.textContent = 'Choisir une image';

            return;
        }

        // Vérification du type
        const typesAutorises = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/webp'
        ];

        if (!typesAutorises.includes(fichier.type)) {

            previewContainer.style.display = 'none';

            imageLabel.textContent = 'Choisir une image';

            return;
        }

        // Afficher le nom du fichier
        imageLabel.textContent = fichier.name;

        // Compression des photos de plus de 5 Mo (avant l'envoi)
        if (fichier.size > SEUIL_COMPRESSION) {

            compresserImage(fichier).then(function (resultat) {

                if (!resultat) {

                    // Compression impossible : on garde l'original
                    afficherApercu(fichier);

                    return;
                }

                const nomSansExtension = fichier.name
                    .replace(/\.[^.]+$/, '');

                const nouveauFichier = new File(
                    [resultat.blob],
                    nomSansExtension + '.' + resultat.ext,
                    { type: resultat.type ?? resultat.blob.type }
                );

                // Remplacer le fichier du champ pour que l'envoi
                // utilise la version compressée.
                try {

                    const transfert = new DataTransfer();
                    transfert.items.add(nouveauFichier);
                    imageInput.files = transfert.files;

                } catch (e) {
                    // Navigateur sans DataTransfer : le serveur
                    // compressera à la réception.
                }

                imageLabel.textContent =
                    nouveauFichier.name + ' — compressée : ' +
                    formatTaille(nouveauFichier.size) +
                    ' (au lieu de ' + formatTaille(fichier.size) + ')';

                afficherApercu(nouveauFichier);
            });

            return;
        }

        afficherApercu(fichier);
    });

    function afficherApercu(fichier) {

        const lecteur = new FileReader();

        lecteur.onload = function (e) {

            preview.src = e.target.result;

            previewContainer.style.display = 'block';

        };

        lecteur.readAsDataURL(fichier);
    }

});

</script>
