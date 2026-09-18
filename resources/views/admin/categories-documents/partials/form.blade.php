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
    >

    @error('nom')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="parent_id">
        Catégorie parente
    </label>

    <select
        name="parent_id"
        id="parent_id"
        class="form-control @error('parent_id') is-invalid @enderror"
    >
        <option value="">-- Catégorie principale --</option>

        @foreach ($categories as $parent)
            <option
                value="{{ $parent->id }}"
                {{ old('parent_id', $categorie->parent_id ?? '') == $parent->id ? 'selected' : '' }}
            >
                {{ $parent->nom }}
            </option>
        @endforeach
    </select>

    @error('parent_id')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

    <small class="form-text text-muted">
        Laissez vide si cette catégorie est une catégorie principale.
    </small>
</div>

<hr>

<div class="d-flex justify-content-between align-items-center">

    <a
        href="{{ route('admin.categories-documents.index') }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Retour
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>
        {{ isset($categorie) ? 'Enregistrer les modifications' : 'Créer la catégorie' }}
    </button>

</div>
