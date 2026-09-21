@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Le formulaire contient des erreurs :</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="contenu">Votre témoignage <span class="text-danger">*</span></label>
                    <textarea id="contenu" name="contenu" rows="6" maxlength="600"
                        class="form-control @error('contenu') is-invalid @enderror"
                        placeholder="Que vous a apporté votre formation à l'ENEF ?" required>{{ old('contenu', $temoignage->contenu) }}</textarea>
                    <small class="form-text text-muted"><span id="compteur">0</span> / 600 caractères</small>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="auteur">Votre nom <span class="text-danger">*</span></label>
                        <input type="text" id="auteur" name="auteur"
                            value="{{ old('auteur', $temoignage->auteur) }}"
                            class="form-control @error('auteur') is-invalid @enderror" required>
                        <small class="form-text text-muted">Vous pouvez n'indiquer que votre prénom et l'initiale de votre nom.</small>
                        @error('auteur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fonction">Votre statut</label>
                        <input type="text" id="fonction" name="fonction"
                            value="{{ old('fonction', $temoignage->fonction) }}"
                            class="form-control @error('fonction') is-invalid @enderror"
                            placeholder="Ex : Ancien élève, promotion 2023">
                        @error('fonction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="formation_concernee">Formation concernée</label>
                    <input type="text" id="formation_concernee" name="formation_concernee"
                        value="{{ old('formation_concernee', $temoignage->formation_concernee) }}"
                        class="form-control @error('formation_concernee') is-invalid @enderror"
                        placeholder="Ex : SIG et Télédétection">
                    @error('formation_concernee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="note">Votre note <span class="text-danger">*</span></label>
                    <select id="note" name="note" class="form-control @error('note') is-invalid @enderror">
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected((int) old('note', $temoignage->note) === $i)>
                                {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }} ({{ $i }}/5)
                            </option>
                        @endfor
                    </select>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="image">Photo (optionnelle)</label>

                    @if ($temoignage->image_url)
                        <div class="text-center mb-2">
                            <img src="{{ asset($temoignage->image_url) }}" alt="Photo actuelle"
                                class="rounded-circle border" style="width:96px;height:96px;object-fit:cover;">
                            <div class="mt-2">
                                <label class="mb-0" style="font-weight:400;">
                                    <input type="checkbox" name="supprimer_image" value="1"> Supprimer la photo
                                </label>
                            </div>
                        </div>
                    @endif

                    <input type="file" id="image" name="image" accept="image/*"
                        class="form-control-file @error('image') is-invalid @enderror">
                    <small class="form-text text-muted">JPG, PNG ou WebP, 2 Mo max. Sans photo, vos initiales sont affichées.</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-right mt-3">
    <a href="{{ route('admin.mes-temoignages.index') }}" class="btn btn-outline-secondary">Annuler</a>
    <button type="submit" class="btn btn-success">{{ $submitLabel ?? 'Enregistrer' }}</button>
</div>

@push('scripts')
    <script>
        (function() {
            var champ = document.getElementById('contenu');
            var compteur = document.getElementById('compteur');
            if (!champ || !compteur) return;
            var maj = function() { compteur.textContent = champ.value.length; };
            champ.addEventListener('input', maj);
            maj();
        })();
    </script>
@endpush