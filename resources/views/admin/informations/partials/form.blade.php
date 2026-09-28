@php $i = $information ?? null; @endphp

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
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" class="form-control" maxlength="200"
            value="{{ old('titre', $i?->titre) }}" required>
    </div>

    <div class="form-group">
        <label for="contenu">Contenu</label>
        <textarea id="contenu" name="contenu" class="form-control" rows="6" required>{{ old('contenu', $i?->contenu) }}</textarea>
    </div>

    <div class="form-group">
        <label for="cible">Destinataires</label>
        <select id="cible" name="cible" class="form-control" required>
            @foreach (\App\Models\Information::CIBLES as $valeur => $libelle)
                <option value="{{ $valeur }}" @selected(old('cible', $i?->cible ?? 'tous') === $valeur)>
                    {{ $libelle }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="fichier">Fichier PDF joint (optionnel, 5 Mo max)</label>
        <div class="custom-file">
            <input type="file" id="fichier" name="fichier" class="custom-file-input" accept="application/pdf">
            <label class="custom-file-label" for="fichier">Choisir un PDF…</label>
        </div>

        @if ($i?->fichier_path)
            <div class="mt-2">
                <i class="fas fa-file-pdf text-danger"></i> Fichier actuel : {{ $i->fichier_nom }}
                <div class="custom-control custom-checkbox mt-1">
                    <input type="checkbox" class="custom-control-input" id="supprimer_fichier"
                        name="supprimer_fichier" value="1">
                    <label class="custom-control-label" for="supprimer_fichier">Supprimer ce fichier</label>
                </div>
                <small class="text-muted">Choisir un nouveau PDF remplace le fichier actuel.</small>
            </div>
        @endif
    </div>

    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="est_publie" name="est_publie" value="1"
            @checked(old('est_publie', $i?->est_publie ?? true))>
        <label class="custom-control-label" for="est_publie">Publier maintenant</label>
    </div>
</div>

<script>
    // Affiche le nom du fichier choisi (Bootstrap 4 custom-file)
    document.getElementById('fichier')?.addEventListener('change', function () {
        this.nextElementSibling.textContent = this.files[0]?.name ?? 'Choisir un PDF…';
    });
</script>