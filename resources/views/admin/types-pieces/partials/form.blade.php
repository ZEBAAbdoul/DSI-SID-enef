{{-- resources/views/admin/types-pieces/partials/form.blade.php --}}
@php
    $tp = $typePiece ?? $typesPiece ?? null;
    $enEdition = $tp !== null;
    $ordreAff = $tp?->ordre ?? $prochainOrdre ?? 0;
@endphp

<div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="code">Code *</label>
        <input type="text" id="code" name="code" class="form-control" maxlength="40" required
            value="{{ old('code', $tp?->code) }}" placeholder="Ex : cni, acte_naissance, diplome">
        <small class="form-text text-muted">Identifiant unique technique (sans espaces).</small>
    </div>

    <div class="form-group">
        <label for="libelle">Libellé *</label>
        <input type="text" id="libelle" name="libelle" class="form-control" maxlength="100" required
            value="{{ old('libelle', $tp?->libelle) }}" placeholder="Ex : Carte d'identité">
    </div>

    <div class="form-group">
        <label for="ordre">Ordre d'affichage</label>
        @if ($enEdition)
            <input type="number" id="ordre" name="ordre" class="form-control" min="0" max="32767"
                value="{{ old('ordre', $ordreAff) }}" required>
            <small class="form-text text-muted">Saisissez un numéro libre. S'il est déjà pris, vous pourrez échanger les positions.</small>
        @else
            <input type="number" id="ordre" class="form-control" value="{{ old('ordre', $ordreAff) }}" disabled readonly>
            <small class="form-text text-muted">Affecté automatiquement à la création (numéro suivant).</small>
        @endif
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="obligatoire" name="obligatoire" value="1"
            {{ old('obligatoire', $tp?->obligatoire ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="obligatoire">Pièce obligatoire pour l'inscription</label>
    </div>

    <div class="form-check mt-2">
        <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1"
            {{ old('actif', $tp?->actif ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="actif">Type de pièce actif</label>
    </div>
</div>