{{-- resources/views/admin/enseignants/partials/form.blade.php --}}
@php
    $e = $enseignant ?? null;
    $enEdition = $e !== null;
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
        <label for="user_id">Utilisateur <span class="text-danger">*</span></label>
        @if ($enEdition)
            <input type="hidden" name="user_id" value="{{ old('user_id', $e?->user_id) }}">
            <input type="text" class="form-control" disabled readonly
                value="{{ trim($e->user?->personne?->prenom . ' ' . $e->user?->personne?->nom) . ' — ' . ($e->user?->email ?? '') }}">
            <small class="form-text text-muted">L'utilisateur ne peut pas être modifié en edition.</small>
        @else
            <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">— Sélectionner un utilisateur —</option>
                @foreach ($users as $user)
                    <option value="{{ $user['id'] }}" {{ old('user_id') == $user['id'] ? 'selected' : '' }}>
                        {{ $user['label'] }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        @endif
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="matricule">Matricule</label>
                <input type="text" id="matricule" name="matricule" class="form-control @error('matricule') is-invalid @enderror"
                    maxlength="30"
                    value="{{ old('matricule', $e?->matricule) }}" placeholder="Ex : ENS-001">
                @error('matricule')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="specialite">Spécialité</label>
                <input type="text" id="specialite" name="specialite" class="form-control @error('specialite') is-invalid @enderror"
                    maxlength="150"
                    value="{{ old('specialite', $e?->specialite) }}" placeholder="Ex : Mathématiques">
                @error('specialite')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                    maxlength="20"
                    value="{{ old('telephone', $e?->telephone) }}" placeholder="Ex : +243 81 234 5678">
                @error('telephone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="statut">Statut <span class="text-danger">*</span></label>
                <select id="statut" name="statut" class="form-control @error('statut') is-invalid @enderror" required>
                    <option value="actif" {{ old('statut', $e?->statut ?? 'actif') === 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ old('statut', $e?->statut ?? 'actif') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="congé" {{ old('statut', $e?->statut ?? 'actif') === 'congé' ? 'selected' : '' }}>Congé</option>
                </select>
                @error('statut')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
