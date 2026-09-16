{{-- resources/views/admin/partenaires/partials/form.blade.php --}}
@php
    $p = $partenaire ?? null;
    $enEdition = $p !== null;
    $ordreAff = $p?->ordre_affichage ?? $prochainOrdre ?? 0;
    $types = [
        'institutionnel' => 'Institutionnel',
        'financier'      => 'Financier',
        'technique'      => 'Technique',
        'academique'     => 'Académique',
        'collectivite'   => 'Collectivité territoriale',
    ];
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
                <label for="nom">Nom du partenaire *</label>
                <input type="text" id="nom" name="nom" class="form-control" maxlength="150" required
                    value="{{ old('nom', $p?->nom) }}" placeholder="Ex : PONASI">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="type">Type *</label>
                <select id="type" name="type" class="form-control" required>
                    @foreach ($types as $typeKey => $typeLabel)
                        <option value="{{ $typeKey }}" {{ old('type', $p?->type) === $typeKey ? 'selected' : '' }}>
                            {{ $typeLabel }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="site_web">Site web</label>
                <input type="url" id="site_web" name="site_web" class="form-control" maxlength="255"
                    value="{{ old('site_web', $p?->site_web) }}" placeholder="https://... (optionnel)">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ordre_affichage">Ordre d'affichage</label>
                @if ($enEdition)
                    <input type="number" id="ordre_affichage" name="ordre_affichage" class="form-control" min="0" max="32767"
                        value="{{ old('ordre_affichage', $ordreAff) }}" required>
                    <small class="form-text text-muted">Saisissez un numéro libre. S'il est déjà pris, vous pourrez échanger les positions.</small>
                @else
                    <input type="number" id="ordre_affichage" class="form-control" value="{{ old('ordre_affichage', $ordreAff) }}" disabled readonly>
                    <small class="form-text text-muted">Affecté automatiquement à la création (numéro suivant).</small>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="logo_url">Logo</label>
        <input type="file" id="logo_url" name="logo_url" class="form-control" accept="image/*">
        <small class="form-text text-muted">JPG, PNG, WEBP, GIF — 2 Mo max.</small>

        <div class="mt-2" id="logo_preview_wrapper" @if (!$p?->logo_url) style="display:none;" @endif>
            <img id="logo_preview"
                src="{{ $p?->logo_url ? asset($p->logo_url) : '' }}"
                alt="Aperçu du logo" class="border rounded p-1"
                style="max-height:60px; background:#fff;">
            <small class="text-muted ml-2" id="logo_preview_label">
                @if ($p?->logo_url)
                    Logo actuel — laissez vide pour le conserver.
                @endif
            </small>
        </div>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3" maxlength="1000"
            placeholder="Courte présentation du partenaire (optionnel)">{{ old('description', $p?->description) }}</textarea>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1"
            {{ old('actif', $p?->actif ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="actif">Partenaire actif</label>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('logo_url');
        var preview = document.getElementById('logo_preview');
        var wrapper = document.getElementById('logo_preview_wrapper');
        var label = document.getElementById('logo_preview_label');

        input.addEventListener('change', function () {
            var file = input.files && input.files[0];

            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    label.textContent = 'Nouveau logo (sera enregistré à la validation).';
                    wrapper.style.display = '';
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>