@csrf
@if (isset($unite))
    @method('PUT')
@endif

<div class="row g-3">

    <div class="col-md-2">
        <label class="form-label">N° <span class="text-danger">*</span></label>
        <input type="number" name="numero" class="form-control @error('numero') is-invalid @enderror" required
            value="{{ old('numero', $unite->numero ?? '') }}">
        @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <label class="form-label">Ordre d'affichage</label>
        <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror"
            value="{{ old('ordre', $unite->ordre ?? 0) }}">
        @error('ordre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-5">
        <label class="form-label">Titre <span class="text-danger">*</span></label>
        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" required
            value="{{ old('titre', $unite->titre ?? '') }}">
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Note (badge, optionnel)</label>
        <input type="text" name="note" class="form-control" placeholder="Ex. à approfondir"
            value="{{ old('note', $unite->note ?? '') }}">
    </div>

    <div class="col-12">
        <label class="form-label">Photo</label>

        @if (!empty($unite?->photo_url))
            <div class="mb-2">
                <img src="{{ $unite->photo_url }}" alt="{{ $unite->titre }}"
                    style="max-width:220px;max-height:140px;object-fit:cover;border:1px solid #dee2e6;border-radius:4px;">
                <div class="form-check mt-2">
                    <input type="checkbox" name="supprimer_photo" id="supprimer_photo" class="form-check-input"
                        value="1">
                    <label class="form-check-label text-danger" for="supprimer_photo">
                        Supprimer la photo actuelle
                    </label>
                </div>
            </div>
        @endif

        <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
            class="form-control @error('photo') is-invalid @enderror">
        <div class="form-text">Formats acceptés : JPG, PNG, WEBP — 4 Mo maximum.</div>
        @error('photo')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Concept <span class="text-danger">*</span></label>
        <textarea name="concept" rows="2" class="form-control @error('concept') is-invalid @enderror" required>{{ old('concept', $unite->concept ?? '') }}</textarea>
        @error('concept')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Objectif général <span class="text-danger">*</span></label>
        <textarea name="objectif_general" rows="2" class="form-control @error('objectif_general') is-invalid @enderror" required>{{ old('objectif_general', $unite->objectif_general ?? '') }}</textarea>
        @error('objectif_general')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <hr>
        <label class="form-label d-block">Objectifs spécifiques</label>
        <div id="objectifs-liste">
            @php $objectifs = old('objectifs_specifiques', $unite->objectifs_specifiques ?? ['']); @endphp
            @forelse ($objectifs as $objectif)
                <div class="input-group mb-2 objectif-row">
                    <input type="text" name="objectifs_specifiques[]" class="form-control"
                        value="{{ $objectif }}">
                    <button type="button" class="btn btn-outline-danger btn-remove-row">&times;</button>
                </div>
            @empty
                <div class="input-group mb-2 objectif-row">
                    <input type="text" name="objectifs_specifiques[]" class="form-control">
                    <button type="button" class="btn btn-outline-danger btn-remove-row">&times;</button>
                </div>
            @endforelse
        </div>
        <button type="button" id="add-objectif" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus me-1"></i> Ajouter un objectif
        </button>
    </div>

    <div class="col-12">
        <hr>
        <label class="form-label d-block">Sous-unités</label>
        <div id="sous-unites-liste">
            @php
                $sousUnites = old('sous_unites', $unite->sous_unites ?? [['nom' => '', 'etat' => '', 'apps' => '']]);
            @endphp
            @forelse ($sousUnites as $su)
                <div class="row g-2 mb-2 align-items-center sous-unite-row">
                    <div class="col-md-3">
                        <input type="text" name="sous_unites[][nom]" class="form-control" placeholder="Nom"
                            value="{{ $su['nom'] ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="sous_unites[][etat]" class="form-control"
                            placeholder="État (optionnel)" value="{{ $su['etat'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="sous_unites[][apps]" class="form-control"
                            placeholder="Applications / thématiques" value="{{ $su['apps'] ?? '' }}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-remove-row w-100">&times;</button>
                    </div>
                </div>
            @empty
                <div class="row g-2 mb-2 align-items-center sous-unite-row">
                    <div class="col-md-3">
                        <input type="text" name="sous_unites[][nom]" class="form-control" placeholder="Nom">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="sous_unites[][etat]" class="form-control"
                            placeholder="État (optionnel)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="sous_unites[][apps]" class="form-control"
                            placeholder="Applications / thématiques">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-remove-row w-100">&times;</button>
                    </div>
                </div>
            @endforelse
        </div>
        <button type="button" id="add-sous-unite" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus me-1"></i> Ajouter une sous-unité
        </button>
    </div>

    <div class="col-12">
        <div class="form-check mt-3">
            <input type="checkbox" name="est_publie" id="est_publie" class="form-check-input" value="1"
                {{ old('est_publie', $unite->est_publie ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="est_publie">Publiée sur le site public</label>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('add-objectif')?.addEventListener('click', function() {
                var wrapper = document.getElementById('objectifs-liste');
                var row = document.createElement('div');
                row.className = 'input-group mb-2 objectif-row';
                row.innerHTML = '<input type="text" name="objectifs_specifiques[]" class="form-control">' +
                    '<button type="button" class="btn btn-outline-danger btn-remove-row">&times;</button>';
                wrapper.appendChild(row);
            });

            document.getElementById('add-sous-unite')?.addEventListener('click', function() {
                var wrapper = document.getElementById('sous-unites-liste');
                var row = document.createElement('div');
                row.className = 'row g-2 mb-2 align-items-center sous-unite-row';
                row.innerHTML =
                    '<div class="col-md-3"><input type="text" name="sous_unites[][nom]" class="form-control" placeholder="Nom"></div>' +
                    '<div class="col-md-2"><input type="text" name="sous_unites[][etat]" class="form-control" placeholder="État (optionnel)"></div>' +
                    '<div class="col-md-6"><input type="text" name="sous_unites[][apps]" class="form-control" placeholder="Applications / thématiques"></div>' +
                    '<div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-remove-row w-100">&times;</button></div>';
                wrapper.appendChild(row);
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-row')) {
                    e.target.closest('.objectif-row, .sous-unite-row')?.remove();
                }
            });

        });
    </script>
@endpush