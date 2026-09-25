{{-- resources/views/admin/user/partials/form.blade.php --}}
{{-- Champs communs aux pages create et edit. Variables : $roles, $user (facultatif : présent en édition) --}}
@php
    $estEdition = isset($user) && $user;
    $personne = $estEdition ? $user->personne : null;
    $estMoi = $estEdition && $user->is(auth()->user());
    // Rôle figé : son propre compte, ou un compte qui a déjà un rôle non attribuable (ex. enseignant)
    $roleVerrouille = $roleVerrouille ?? false;
    $roleFige = $estMoi || $roleVerrouille;

    $nationalite = old('nationalite_type', $personne->nationalite_type ?? 'nationale');
    $dateNaissance = old(
        'date_naissance',
        $personne?->date_naissance ? \Carbon\Carbon::parse($personne->date_naissance)->format('Y-m-d') : '',
    );
    $roleActuel = old('role', $estEdition ? optional($user->roles->first())->name : null);
    $actif = (bool) old('est_actif', $estEdition ? ($user->est_actif ? 1 : 0) : 1);
@endphp

{{-- ===================== IDENTITÉ ===================== --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-id-card text-primary me-2"></i> Identité</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-4">
                <label for="nationalite_type" class="form-label fw-bold">Nationalité <span
                        class="text-danger">*</span></label>
                <select id="nationalite_type" name="nationalite_type"
                    class="form-select @error('nationalite_type') is-invalid @enderror" required>
                    <option value="nationale" @selected($nationalite === 'nationale')>Nationale (Burkina Faso)</option>
                    <option value="internationale" @selected($nationalite === 'internationale')>Internationale</option>
                </select>
                @error('nationalite_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4" id="paysNationaliteWrap" style="display:none;">
                <label for="pays_nationalite" class="form-label fw-bold">Pays de nationalité <span
                        class="text-danger">*</span></label>
                <input type="text" id="pays_nationalite" name="pays_nationalite"
                    class="form-control @error('pays_nationalite') is-invalid @enderror"
                    value="{{ old('pays_nationalite', $personne->pays_nationalite ?? '') }}" maxlength="100">
                @error('pays_nationalite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="w-100 m-0"></div>

            <div class="col-md-4">
                <label for="nom" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                <input type="text" id="nom" name="nom"
                    class="form-control @error('nom') is-invalid @enderror"
                    value="{{ old('nom', $personne->nom ?? '') }}" maxlength="100" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="prenom" class="form-label fw-bold">Prénom(s) <span class="text-danger">*</span></label>
                <input type="text" id="prenom" name="prenom"
                    class="form-control @error('prenom') is-invalid @enderror"
                    value="{{ old('prenom', $personne->prenom ?? '') }}" maxlength="100" required>
                @error('prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="sexe" class="form-label fw-bold">Sexe <span class="text-danger">*</span></label>
                <select id="sexe" name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                    <option value="">— Choisir —</option>
                    <option value="M" @selected(old('sexe', $personne->sexe ?? '') === 'M')>Masculin</option>
                    <option value="F" @selected(old('sexe', $personne->sexe ?? '') === 'F')>Féminin</option>
                </select>
                @error('sexe')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="date_naissance" class="form-label fw-bold">Date de naissance <span
                        class="text-danger">*</span></label>
                <input type="date" id="date_naissance" name="date_naissance"
                    class="form-control @error('date_naissance') is-invalid @enderror" value="{{ $dateNaissance }}"
                    max="{{ now()->subDay()->format('Y-m-d') }}" required>
                @error('date_naissance')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="lieu_naissance" class="form-label fw-bold">Lieu de naissance <span
                        class="text-danger">*</span></label>
                <input type="text" id="lieu_naissance" name="lieu_naissance"
                    class="form-control @error('lieu_naissance') is-invalid @enderror"
                    value="{{ old('lieu_naissance', $personne->lieu_naissance ?? '') }}" maxlength="150" required>
                @error('lieu_naissance')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>
</div>

{{-- ===================== PIÈCE D'IDENTITÉ & CONTACT ===================== --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-address-book text-primary me-2"></i> Pièce d'identité et contact</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-4">
                <label for="piece_type" class="form-label fw-bold">Type de pièce <span
                        class="text-danger">*</span></label>
                <select id="piece_type" name="piece_type" class="form-select @error('piece_type') is-invalid @enderror"
                    required>
                    <option value="cnib" @selected(old('piece_type', $personne->piece_type ?? 'cnib') === 'cnib')>CNIB</option>
                    <option value="passeport" @selected(old('piece_type', $personne->piece_type ?? 'cnib') === 'passeport')>Passeport</option>
                </select>
                @error('piece_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="piece_numero" class="form-label fw-bold">Numéro de la pièce <span
                        class="text-danger">*</span></label>
                <input type="text" id="piece_numero" name="piece_numero"
                    class="form-control @error('piece_numero') is-invalid @enderror"
                    value="{{ old('piece_numero', $personne->piece_numero ?? '') }}" maxlength="30" required>
                @error('piece_numero')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="telephone_indicatif" class="form-label fw-bold">Indicatif <span
                        class="text-danger">*</span></label>
                <input type="text" id="telephone_indicatif" name="telephone_indicatif"
                    class="form-control @error('telephone_indicatif') is-invalid @enderror"
                    value="{{ old('telephone_indicatif', $personne->telephone_indicatif ?? '+226') }}" maxlength="6"
                    required>
                @error('telephone_indicatif')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-9">
                <label for="telephone" class="form-label fw-bold">Téléphone <span
                        class="text-danger">*</span></label>
                <input type="tel" id="telephone" name="telephone"
                    class="form-control @error('telephone') is-invalid @enderror"
                    value="{{ old('telephone', $personne->telephone ?? '') }}" maxlength="20" required>
                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>
</div>

{{-- ===================== RÉSIDENCE ===================== --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i> Résidence</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-12">
                <label for="adresse" class="form-label fw-bold">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                    class="form-control @error('adresse') is-invalid @enderror"
                    value="{{ old('adresse', $personne->adresse ?? '') }}" maxlength="255">
                @error('adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="ville" class="form-label fw-bold">Ville</label>
                <input type="text" id="ville" name="ville"
                    class="form-control @error('ville') is-invalid @enderror"
                    value="{{ old('ville', $personne->ville ?? '') }}" maxlength="100">
                @error('ville')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="pays_residence" class="form-label fw-bold">Pays de résidence <span
                        class="text-danger">*</span></label>
                <input type="text" id="pays_residence" name="pays_residence"
                    class="form-control @error('pays_residence') is-invalid @enderror"
                    value="{{ old('pays_residence', $personne->pays_residence ?? 'Burkina Faso') }}" maxlength="100"
                    required>
                @error('pays_residence')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>
</div>

{{-- ===================== COMPTE ===================== --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-user-shield text-primary me-2"></i> Compte utilisateur</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label for="email" class="form-label fw-bold">Adresse e-mail <span
                        class="text-danger">*</span></label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $estEdition ? $user->email : '') }}" maxlength="255" autocomplete="off"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label fw-bold">Rôle <span class="text-danger">*</span></label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror"
                    @if ($roleFige) disabled @else required @endif>
                    <option value="">— Choisir un rôle —</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected($roleActuel === $role->name)>{{ $role->name }}</option>
                    @endforeach
                    {{-- Rôle non attribuable déjà porté par le compte (ex. enseignant) : affiché, mais non modifiable --}}
                    @if ($roleVerrouille && $estEdition)
                        @foreach ($user->roles as $roleActuelUser)
                            @unless ($roles->contains('name', $roleActuelUser->name))
                                <option value="{{ $roleActuelUser->name }}" selected>{{ $roleActuelUser->name }}</option>
                            @endunless
                        @endforeach
                    @endif
                </select>
                @if ($roleVerrouille)
                    <div class="form-text">Ce rôle est attribué automatiquement (inscription des candidats, module
                        Enseignants) : il ne peut pas être modifié ici.</div>
                @elseif ($estMoi)
                    <div class="form-text">Vous ne pouvez pas modifier votre propre rôle.</div>
                @endif
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- @if ($estEdition)
                <div class="col-md-6">
                    <label for="password" class="form-label fw-bold">
                        {{ $estEdition ? 'Nouveau mot de passe' : 'Mot de passe' }}
                        @unless ($estEdition)
                            <span class="text-danger">*</span>
                        @endunless
                    </label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" autocomplete="new-password"
                        minlength="12" @unless ($estEdition) required @endunless>
                    @if ($estEdition)
                        <div class="form-text">Laissez vide pour conserver le mot de passe actuel (12 caractères
                            minimum).</div>
                    @endif
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control" autocomplete="new-password">
                </div>
            @else
                <div class="col-12">
                    <div class="alert alert-info mb-0" role="note">
                        <i class="fas fa-envelope me-1"></i>
                        Un mot de passe temporaire sera <strong>généré automatiquement</strong> et envoyé à
                        l'utilisateur par e-mail, avec son identifiant de connexion.
                    </div>
                </div>
            @endif --}}

            <div class="col-12">
                {{-- Le champ caché garantit l'envoi de 0 quand la case est décochée --}}
                <input type="hidden" name="est_actif" value="0">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="est_actif" name="est_actif"
                        value="1" @checked($actif) @disabled($estMoi)>
                    <label class="form-check-label fw-bold" for="est_actif">Compte actif</label>
                </div>
                <div class="form-text">
                    @if ($estMoi)
                        Vous ne pouvez pas désactiver votre propre compte.
                    @else
                        Un compte désactivé ne peut plus se connecter.
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        // Le champ "Pays de nationalité" n'apparaît que pour une nationalité internationale
        var select = document.getElementById('nationalite_type');
        var wrap = document.getElementById('paysNationaliteWrap');
        var pays = document.getElementById('pays_nationalite');

        function maj() {
            var inter = select.value === 'internationale';
            wrap.style.display = inter ? '' : 'none';
            pays.required = inter;
        }

        select.addEventListener('change', maj);
        maj();
    })();
</script>
