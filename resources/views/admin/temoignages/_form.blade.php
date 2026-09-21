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

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="contenu" class="form-label">Témoignage <span class="text-danger">*</span></label>
                    <textarea id="contenu" name="contenu" rows="5" maxlength="600"
                        class="form-control @error('contenu') is-invalid @enderror" required>{{ old('contenu', $temoignage->contenu) }}</textarea>
                    <div class="form-text"><span id="compteur">0</span> / 600 caractères</div>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="auteur" class="form-label">Auteur <span class="text-danger">*</span></label>
                        <input type="text" id="auteur" name="auteur"
                            value="{{ old('auteur', $temoignage->auteur) }}"
                            class="form-control @error('auteur') is-invalid @enderror" placeholder="Ex : Aminata O."
                            required>
                        @error('auteur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fonction" class="form-label">Statut / fonction</label>
                        <input type="text" id="fonction" name="fonction"
                            value="{{ old('fonction', $temoignage->fonction) }}"
                            class="form-control @error('fonction') is-invalid @enderror"
                            placeholder="Ex : Ancienne élève, Promotion 2023">
                        @error('fonction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="formation_concernee" class="form-label">Formation concernée</label>
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
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="note" class="form-label">Note <span class="text-danger">*</span></label>
                    <select id="note" name="note" class="form-select @error('note') is-invalid @enderror">
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

                <div class="mb-3">
                    <label for="ordre" class="form-label">Ordre d'affichage</label>
                    <input type="number" id="ordre" name="ordre" min="0"
                        value="{{ old('ordre', $temoignage->ordre) }}"
                        class="form-control @error('ordre') is-invalid @enderror">
                    <div class="form-text">Les plus petits numéros apparaissent en premier.</div>
                    @error('ordre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch">
                    <input type="hidden" name="est_publie" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="est_publie" name="est_publie"
                        value="1" @checked(old('est_publie', $temoignage->est_publie))>
                    <label class="form-check-label" for="est_publie">Publier sur le site</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <label for="image" class="form-label">Photo (optionnelle)</label>

                @if ($temoignage->image_url)
                    <div class="mb-3 text-center">
                        <img src="{{ asset($temoignage->image_url) }}" alt="Photo actuelle"
                            class="rounded-circle border" style="width:96px;height:96px;object-fit:cover;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="supprimer_image" value="1"
                                id="supprimer_image">
                            <label class="form-check-label" for="supprimer_image">Supprimer la photo</label>
                        </div>
                    </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*"
                    class="form-control @error('image') is-invalid @enderror">
                <div class="form-text">JPG, PNG ou WebP, 2 Mo max. Sans photo, les initiales sont affichées.</div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.temoignages.index') }}" class="btn btn-outline-secondary">Annuler</a>
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