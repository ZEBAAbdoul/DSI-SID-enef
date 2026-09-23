{{-- resources/views/admin/matieres/partials/form.blade.php --}}
@php
    $m = $matiere ?? null;
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

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nom">Nom de la matière <span class="text-danger">*</span></label>
                <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror"
                    maxlength="150" required
                    value="{{ old('nom', $m?->nom) }}" placeholder="Ex : Programmation Web">
                @error('nom')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
                    maxlength="20"
                    value="{{ old('code', $m?->code) }}" placeholder="Ex : PW">
                @error('code')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="filiere_id">Filière</label>
        <select id="filiere_id" name="filiere_id" class="form-control @error('filiere_id') is-invalid @enderror">
            <option value="">— Aucune filière —</option>
            @foreach ($filieres as $fl)
                <option value="{{ $fl->id }}" {{ old('filiere_id', $m?->filiere_id) == $fl->id ? 'selected' : '' }}>
                    {{ $fl->nom }}
                </option>
            @endforeach
        </select>
        @error('filiere_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="coefficient">Coefficient <span class="text-danger">*</span></label>
                <input type="number" step="0.25" min="0" max="99" id="coefficient" name="coefficient"
                    class="form-control @error('coefficient') is-invalid @enderror"
                    value="{{ old('coefficient', $m?->coefficient ?? 1) }}" required>
                @error('coefficient')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="volume_horaire">Volume horaire (heures)</label>
                <input type="number" min="0" max="10000" id="volume_horaire" name="volume_horaire"
                    class="form-control @error('volume_horaire') is-invalid @enderror"
                    value="{{ old('volume_horaire', $m?->volume_horaire) }}" placeholder="Ex : 60">
                @error('volume_horaire')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>