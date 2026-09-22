<div class="mb-3">
    <label for="categorie" class="form-label">Catégorie</label>
    <select name="categorie" id="categorie"
            class="form-select @error('categorie') is-invalid @enderror" required>
        <option value="">-- Sélectionner --</option>
        @foreach ($categories as $key => $label)
            <option value="{{ $key }}"
                @selected(old('categorie', $information->categorie ?? '') === $key)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('categorie')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="libelle" class="form-label">Libellé</label>
    <input type="text" name="libelle" id="libelle"
           class="form-control @error('libelle') is-invalid @enderror"
           value="{{ old('libelle', $information->libelle ?? '') }}" required maxlength="255">
    @error('libelle')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="valeur" class="form-label">Valeur <span class="text-muted">(optionnelle)</span></label>
    <input type="text" name="valeur" id="valeur"
           class="form-control @error('valeur') is-invalid @enderror"
           value="{{ old('valeur', $information->valeur ?? '') }}" maxlength="255">
    @error('valeur')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="ordre" class="form-label">Ordre</label>
    <input type="number" name="ordre" id="ordre" min="0"
           class="form-control @error('ordre') is-invalid @enderror"
           value="{{ old('ordre', $information->ordre ?? 0) }}" required>
    @error('ordre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>