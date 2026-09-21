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

    {{-- <div class="form-check">
        <input type="checkbox" class="form-check-input" id="obligatoire" name="obligatoire" value="1"
            {{ old('obligatoire', $tp?->obligatoire ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="obligatoire">Pièce obligatoire pour l'inscription</label>
    </div>

    <div class="form-check mt-2">
        <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1"
            {{ old('actif', $tp?->actif ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="actif">Type de pièce actif</label>
    </div> --}}



{{-- Pièce obligatoire --}}
<div class="toggle-wrapper mb-3">

    <label class="toggle mb-0">
        <input
            type="checkbox"
            name="obligatoire"
            id="obligatoire"
            value="1"
            {{ old('obligatoire', $tp?->obligatoire ?? true) ? 'checked' : '' }}
        >

        <span class="toggle-slider"></span>
    </label>

    <span class="toggle-label" id="obligatoireLabel">
        {{ old('obligatoire', $tp?->obligatoire ?? true)
            ? 'Pièce obligatoire pour l’inscription'
            : 'Pièce non obligatoire pour l’inscription'
        }}
    </span>

</div>


{{-- Type de pièce actif --}}
<div class="toggle-wrapper">

    <label class="toggle mb-0">
        <input
            type="checkbox"
            name="actif"
            id="actif"
            value="1"
            {{ old('actif', $tp?->actif ?? true) ? 'checked' : '' }}
        >

        <span class="toggle-slider"></span>
    </label>

    <span class="toggle-label" id="actifLabel">
        {{ old('actif', $tp?->actif ?? true)
            ? 'Type de pièce actif'
            : 'Type de pièce inactif'
        }}
    </span>

</div>



</div>
    <style>
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toggle {
        position: relative;
        width: 50px;
        height: 26px;
        flex-shrink: 0;
    }

    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .toggle-slider {
        position: absolute;
        inset: 0;
        cursor: pointer;
        background-color: #adb5bd;
        border-radius: 30px;
        transition: 0.25s ease;
    }

    .toggle-slider::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        left: 3px;
        top: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .25);
    }

    .toggle input:checked + .toggle-slider {
        background-color: #198754;
    }

    .toggle input:checked + .toggle-slider::before {
        transform: translateX(24px);
    }

    .toggle-label {
        font-weight: 600;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const obligatoire = document.getElementById('obligatoire');
        const obligatoireLabel = document.getElementById('obligatoireLabel');

        const actif = document.getElementById('actif');
        const actifLabel = document.getElementById('actifLabel');


        obligatoire.addEventListener('change', function () {
            obligatoireLabel.textContent = this.checked
                ? 'Pièce obligatoire pour l’inscription'
                : 'Pièce non obligatoire pour l’inscription';
        });


        actif.addEventListener('change', function () {
            actifLabel.textContent = this.checked
                ? 'Type de pièce actif'
                : 'Type de pièce inactif';
        });

    });
</script>
