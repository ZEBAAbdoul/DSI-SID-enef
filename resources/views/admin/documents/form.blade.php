@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
        <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror"
            value="{{ old('titre', $document->titre) }}" required>
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
        <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
            <option value="">— Choisir —</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $document->categorie_id) == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $document->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="">— Choisir —</option>
            @foreach ($typeOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $document->type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="acces" class="form-label">Accès <span class="text-danger">*</span></label>
        <select name="acces" id="acces" class="form-select @error('acces') is-invalid @enderror" required>
            <option value="">— Choisir —</option>
            @foreach ($accesOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('acces', $document->acces) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('acces')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="version" class="form-label">Version</label>
        <input type="text" name="version" id="version" class="form-control @error('version') is-invalid @enderror"
            value="{{ old('version', $document->version) }}" placeholder="ex. 1.0">
        @error('version')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="publie_le" class="form-label">Date de publication</label>
        <input type="date" name="publie_le" id="publie_le" class="form-control @error('publie_le') is-invalid @enderror"
            value="{{ old('publie_le', optional($document->publie_le)->format('Y-m-d')) }}">
        @error('publie_le')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="code_consultation" class="form-label">Code de consultation</label>
        <input type="text" name="code_consultation" id="code_consultation"
            class="form-control @error('code_consultation') is-invalid @enderror"
            value="{{ old('code_consultation', $document->code_consultation) }}"
            placeholder="ex. DOC-RA-001" maxlength="30">
        @error('code_consultation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
            Visible par tous les visiteurs. Permet à ceux qui ne peuvent pas télécharger ce document de le
            référencer pour une consultation sur place.
        </div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input type="hidden" name="telechargeable" value="0">
            <input type="checkbox" name="telechargeable" id="telechargeable" value="1"
                class="form-check-input @error('telechargeable') is-invalid @enderror"
                {{ old('telechargeable', $document->exists ? $document->telechargeable : true) ? 'checked' : '' }}>
            <label for="telechargeable" class="form-check-label">
                Téléchargeable par les visiteurs
            </label>
            @error('telechargeable')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-text">
            Si désactivé, le document sera proposé en consultation sur place uniquement (le code ci-dessus sera
            affiché à la place du bouton de téléchargement).
        </div>
    </div>

    <div class="col-md-6">
        <label for="fichier" class="form-label">
            Fichier
            <span class="text-muted small">(optionnel — requis uniquement si « téléchargeable » est activé et
                qu'aucun fichier n'est déjà associé)</span>
        </label>
        <input type="file" name="fichier" id="fichier" class="form-control @error('fichier') is-invalid @enderror"
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
        @error('fichier')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if ($document->exists && $document->fichier_url)
            <div class="form-text">
                Fichier actuel : {{ basename($document->fichier_url) }}
                ({{ $document->format_fichier ? strtoupper($document->format_fichier) : '' }}@if($document->taille_fichier_ko), {{ number_format($document->taille_fichier_ko / 1024, 2) }} Mo @endif)
                — laisse ce champ vide pour le conserver.
            </div>
        @endif
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg"></i> {{ $document->exists ? 'Enregistrer les modifications' : 'Créer le document' }}
    </button>
    <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>