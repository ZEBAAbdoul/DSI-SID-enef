@csrf

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $erreur)
                <li>{{ $erreur }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h5 class="mt-2 mb-3">Identité</h5>
<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nom <span class="text-danger">*</span></label>
        <input type="text" name="nom" class="form-control"
               value="{{ old('nom', $enseignant->personne->nom ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Prénom <span class="text-danger">*</span></label>
        <input type="text" name="prenom" class="form-control"
               value="{{ old('prenom', $enseignant->personne->prenom ?? '') }}" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Sexe <span class="text-danger">*</span></label>
        <select name="sexe" class="form-select" required>
            <option value="M" @selected(old('sexe', $enseignant->personne->sexe ?? '') === 'M')>Masculin</option>
            <option value="F" @selected(old('sexe', $enseignant->personne->sexe ?? '') === 'F')>Féminin</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
        <input type="date" name="date_naissance" class="form-control"
               value="{{ old('date_naissance', optional($enseignant->personne->date_naissance ?? null)->format('Y-m-d')) }}" required>
    </div>

    <div class="col-md-5">
        <label class="form-label">Lieu de naissance <span class="text-danger">*</span></label>
        <input type="text" name="lieu_naissance" class="form-control"
               value="{{ old('lieu_naissance', $enseignant->personne->lieu_naissance ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Nationalité <span class="text-danger">*</span></label>
        <select name="nationalite_type" class="form-select" required>
            <option value="nationale" @selected(old('nationalite_type', $enseignant->personne->nationalite_type ?? 'nationale') === 'nationale')>Nationale</option>
            <option value="internationale" @selected(old('nationalite_type', $enseignant->personne->nationalite_type ?? '') === 'internationale')>Internationale</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Pays de nationalité</label>
        <input type="text" name="pays_nationalite" class="form-control"
               value="{{ old('pays_nationalite', $enseignant->personne->pays_nationalite ?? 'Burkina Faso') }}">
    </div>

</div>

<h5 class="mt-4 mb-3">Pièce d'identité</h5>
<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Type de pièce <span class="text-danger">*</span></label>
        <select name="piece_type" class="form-select" required>
            <option value="cnib" @selected(old('piece_type', $enseignant->personne->piece_type ?? '') === 'cnib')>CNIB</option>
            <option value="passeport" @selected(old('piece_type', $enseignant->personne->piece_type ?? '') === 'passeport')>Passeport</option>
        </select>
    </div>

    <div class="col-md-8">
        <label class="form-label">Numéro de la pièce <span class="text-danger">*</span></label>
        <input type="text" name="piece_numero" class="form-control"
               value="{{ old('piece_numero', $enseignant->personne->piece_numero ?? '') }}" required>
    </div>

</div>

<h5 class="mt-4 mb-3">Contact</h5>
<div class="row g-3">

    <div class="col-md-2">
        <label class="form-label">Indicatif</label>
        <input type="text" name="telephone_indicatif" class="form-control"
               value="{{ old('telephone_indicatif', $enseignant->personne->telephone_indicatif ?? '+226') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
        <input type="text" name="telephone_personne" class="form-control"
               value="{{ old('telephone_personne', $enseignant->personne->telephone ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $enseignant->user->email ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control"
               value="{{ old('ville', $enseignant->personne->ville ?? '') }}">
    </div>

    <div class="col-md-8">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control"
               value="{{ old('adresse', $enseignant->personne->adresse ?? '') }}">
    </div>

</div>

<h5 class="mt-4 mb-3">Profil enseignant</h5>
<div class="row g-3">

    <div class="col-md-5">
        <label class="form-label">Spécialité</label>
        <input type="text" name="specialite" class="form-control"
               value="{{ old('specialite', $enseignant->specialite ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Statut <span class="text-danger">*</span></label>
        <select name="statut" class="form-select" required>
            <option value="actif" @selected(old('statut', $enseignant->statut ?? 'actif') === 'actif')>Actif</option>
            <option value="inactif" @selected(old('statut', $enseignant->statut ?? '') === 'inactif')>Inactif</option>
            <option value="suspendu" @selected(old('statut', $enseignant->statut ?? '') === 'suspendu')>Suspendu</option>
        </select>
    </div>

    {{-- <div class="col-md-4">
        <label class="form-label">
            Mot de passe
            @if($enseignant ?? null)
                <span class="text-muted small">(laisser vide pour ne pas changer)</span>
            @else
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="password" name="password" class="form-control"
               {{ ($enseignant ?? null) ? '' : 'required' }}>
    </div> --}}

</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('admin.enseignants.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>