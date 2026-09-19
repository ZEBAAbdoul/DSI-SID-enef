
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

        <label class="custom-file-label" for="image">
            Choisir une image
        </label>

    </div>

    <small class="form-text text-muted">
        Formats acceptés : JPG, JPEG, PNG, GIF, WEBP — 5 Mo maximum.
    </small>

    @error('image')
        <span class="text-danger d-block mt-1">
            {{ $message }}
        </span>
    @enderror
</div>


{{-- Aperçu de la nouvelle image --}}
<div
    id="image-preview-container"
    class="form-group"
    style="display:none;"
>
    <label>Aperçu</label>

    <div>
        <img
            id="image-preview"
            src="#"
            alt="Aperçu"
            class="img-thumbnail"
            style="max-width:300px; max-height:200px;"
        >
    </div>
</div>


@if (isset($photo) && $photo->image_url)

    <div class="form-group">

        <label>Image actuelle</label>

        <div>
            <img
                src="{{ asset('storage/' . $photo->image_url) }}"
                alt="{{ $photo->titre }}"
                class="img-thumbnail"
                style="max-width:300px; max-height:200px;"
            >
        </div>

    </div>

@endif


<div class="row">

    <div class="col-md-6">

        <div class="form-group">

            <label for="ordre">
                Ordre d'affichage
            </label>

            <input
                type="number"
                name="ordre"
                id="ordre"
                class="form-control @error('ordre') is-invalid @enderror"
                value="{{ old('ordre', $photo->ordre ?? 0) }}"
                min="0"
            >

            @error('ordre')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    <div class="col-md-6">

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
                    {{ old('est_visible', $photo->est_visible ?? true) ? 'checked' : '' }}
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


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        if (imageInput) {

            imageInput.addEventListener('change', function (event) {

                const file = event.target.files[0];

                if (!file) {
                    previewContainer.style.display = 'none';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {

                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';

                };

                reader.readAsDataURL(file);

            });

        }

    });
</script>

