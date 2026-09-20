@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="titre">Titre de l'idée <span class="text-danger">*</span></label>
            <input type="text" id="titre" name="titre" maxlength="150"
                value="{{ old('titre', $idee->titre) }}"
                class="form-control @error('titre') is-invalid @enderror" required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="categorie">Domaine concerné</label>
            <select id="categorie" name="categorie" class="form-control @error('categorie') is-invalid @enderror">
                <option value="">— Non précisé —</option>
                @foreach (\App\Models\Idee::CATEGORIES as $cle => $libelle)
                    <option value="{{ $cle }}" @selected(old('categorie', $idee->categorie) === $cle)>{{ $libelle }}</option>
                @endforeach
            </select>
            @error('categorie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-0">
            <label for="description">Décrivez votre idée <span class="text-danger">*</span></label>
            <textarea id="description" name="description" rows="8" maxlength="2000"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Quel problème ou quelle amélioration ? Comment la mettre en œuvre ?" required>{{ old('description', $idee->description) }}</textarea>
            <small class="form-text text-muted">2000 caractères maximum.</small>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="text-right mt-3">
    <a href="{{ route('admin.idees.index') }}" class="btn btn-outline-secondary">Annuler</a>
    <button type="submit" class="btn btn-success">{{ $submitLabel ?? 'Enregistrer' }}</button>
</div>