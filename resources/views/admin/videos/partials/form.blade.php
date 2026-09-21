

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
        value="{{ old('titre', $video->titre ?? '') }}"
        placeholder="Ex : Présentation de l'institution"
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

    <label for="url">
        Lien de la vidéo
        <span class="text-danger">*</span>
    </label>

    <input
        type="url"
        name="url"
        id="url"
        class="form-control @error('url') is-invalid @enderror"
        value="{{ old('url', $video->url ?? '') }}"
        placeholder="https://www.youtube.com/watch?v=..."
        required
    >

    @error('url')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

    <small class="form-text text-muted">
        Entrez le lien complet de la vidéo.
        Exemple : YouTube, Facebook, Vimeo, etc.
    </small>

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
        placeholder="Description de la vidéo..."
    >{{ old('description', $video->description ?? '') }}</textarea>

    @error('description')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>


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
                value="{{ old('ordre', $video->ordre ?? 0) }}"
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
                    {{ old('est_visible', $video->est_visible ?? true) ? 'checked' : '' }}
                >

                <label
                    class="custom-control-label"
                    for="est_visible"
                >
                    Vidéo visible
                </label>

            </div>

        </div>

    </div>

</div>


<div class="d-flex justify-content-between mt-4">

    <a
        href="{{ route('admin.videos.index') }}"
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

        {{ isset($video)
            ? 'Enregistrer les modifications'
            : 'Ajouter la vidéo'
        }}

    </button>

</div>

