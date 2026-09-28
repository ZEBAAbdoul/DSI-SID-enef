{{-- resources/views/admin/sessions-formation/partials/form.blade.php --}}
@php
    $s = $session ?? null;
    $isEdit = $s !== null;
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
        @if ($isEdit)
            {{-- Édition : une seule formation --}}
            <label for="formation_id">Formation</label>
            <select id="formation_id" name="formation_id" class="form-control" required>
                <option value="">Sélectionner…</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" @selected(old('formation_id', $s->formation_id) == $formation->id)>
                        {{ $formation->titre }}
                    </option>
                @endforeach
            </select>
        @else
            {{-- Création : plusieurs formations --}}
            <label>Formations (une ou plusieurs)</label>

            <div class="border rounded p-2">
                <div class="input-group input-group-sm mb-2">
                    <input type="text" id="formation-search" class="form-control"
                        placeholder="Rechercher une formation…">
                    <div class="input-group-append">
                        <button type="button" id="formation-toggle-all" class="btn btn-outline-secondary">
                            Tout sélectionner
                        </button>
                    </div>
                </div>

                <div id="formation-list" style="max-height: 220px; overflow-y: auto;">
                    @foreach ($formations as $formation)
                        <div class="custom-control custom-checkbox formation-item">
                            <input type="checkbox" class="custom-control-input formation-check"
                                id="formation_{{ $formation->id }}" name="formation_ids[]" value="{{ $formation->id }}"
                                @checked(in_array($formation->id, old('formation_ids', [])))>
                            <label class="custom-control-label" for="formation_{{ $formation->id }}">
                                {{ $formation->titre }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <small class="text-muted d-block mt-2">
                    <span id="formation-count">0</span> sélectionnée(s) — une session sera créée pour chacune.
                </small>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" class="form-control"
                    value="{{ old('date_debut', $s?->date_debut?->format('Y-m-d')) }}" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="date_fin">Date de fin (optionnel)</label>
                <input type="date" id="date_fin" name="date_fin" class="form-control"
                    value="{{ old('date_fin', $s?->date_fin?->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="date_limite_depot">Date limite de dépôt des dossiers (optionnel)</label>
                <input type="date" id="date_limite_depot" name="date_limite_depot" class="form-control"
                    value="{{ old('date_limite_depot', $s?->date_limite_depot?->format('Y-m-d')) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="lieu">Lieu</label>
                <input type="text" id="lieu" name="lieu" class="form-control"
                    value="{{ old('lieu', $s?->lieu) }}" placeholder="Ex : Bobo-Dioulasso - ENEF">
            </div>
        </div>

    </div>

    {{-- <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="date_limite_depot">Date limite de dépôt des dossiers (optionnel)</label>
            <input type="date" id="date_limite_depot" name="date_limite_depot" class="form-control"
                value="{{ old('date_limite_depot', $s?->date_limite_depot?->format('Y-m-d')) }}">
        </div>
    </div> --}}
</div>

{{-- <div class="form-group">
    <label for="lieu">Lieu</label>
    <input type="text" id="lieu" name="lieu" class="form-control" value="{{ old('lieu', $s?->lieu) }}"
        placeholder="Ex : Ouagadougou - Campus principal">
</div> --}}

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="places_totales">Places totales</label>
            <input type="number" id="places_totales" name="places_totales" class="form-control" min="1"
                value="{{ old('places_totales', $s?->places_totales ?? 20) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="places_disponibles">Places disponibles</label>
            <input type="number" id="places_disponibles" name="places_disponibles" class="form-control" min="0"
                value="{{ old('places_disponibles', $s?->places_disponibles ?? 20) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="statut">Statut</label>
            <select id="statut" name="statut" class="form-control" required>
                <option value="ouverte" @selected(old('statut', $s?->statut) === 'ouverte')>Ouverte</option>
                <option value="complete" @selected(old('statut', $s?->statut) === 'complete')>Complète</option>
                <option value="cloturee" @selected(old('statut', $s?->statut) === 'cloturee')>Clôturée</option>
            </select>
        </div>
    </div>
</div>
</div>

@unless ($isEdit)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const search = document.getElementById('formation-search');
            const toggle = document.getElementById('formation-toggle-all');
            const count = document.getElementById('formation-count');
            const items = [...document.querySelectorAll('.formation-item')];
            const checks = [...document.querySelectorAll('.formation-check')];

            const visibleChecks = () =>
                items.filter(i => i.style.display !== 'none').map(i => i.querySelector('input'));

            const refresh = () => {
                count.textContent = checks.filter(c => c.checked).length;
                const v = visibleChecks();
                toggle.textContent = v.length && v.every(c => c.checked) ?
                    'Tout désélectionner' : 'Tout sélectionner';
            };

            search.addEventListener('input', () => {
                const q = search.value.trim().toLowerCase();
                items.forEach(i => {
                    i.style.display = i.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
                refresh();
            });

            toggle.addEventListener('click', () => {
                const v = visibleChecks();
                const all = v.every(c => c.checked);
                v.forEach(c => c.checked = !all);
                refresh();
            });

            checks.forEach(c => c.addEventListener('change', refresh));
            refresh();
        });
    </script>
@endunless
