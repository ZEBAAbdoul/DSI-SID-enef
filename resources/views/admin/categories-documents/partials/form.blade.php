{{-- resources/views/admin/categories-documents/_form.blade.php --}}

<div class="form-group">
    <label for="nom">
        Nom de la catégorie
        <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="nom"
        id="nom"
        class="form-control @error('nom') is-invalid @enderror"
        value="{{ old('nom', $categorie->nom ?? '') }}"
        placeholder="Ex : Documents administratifs"
        maxlength="150"
        required
        autofocus
    >

    @error('nom')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="d-flex justify-content-between mt-4">

    <a
        href="{{ route('admin.categories-documents.index') }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Retour
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>

        {{ isset($categorie)
            ? 'Enregistrer les modifications'
            : 'Créer la catégorie'
        }}
    </button>

</div>
