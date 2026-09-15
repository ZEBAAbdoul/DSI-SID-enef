{{-- resources/views/admin/sessions-formation/partials/form.blade.php --}}
@php
    $s = $session ?? null;
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
        <label for="formation_id">Formation</label>
        <select id="formation_id" name="formation_id" class="form-control" required>
            <option value="">Sélectionner…</option>
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}" @selected(old('formation_id', $s?->formation_id) == $formation->id)>
                    {{ $formation->titre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" class="form-control"
                    value="{{ old('date_debut', $s?->date_debut?->format('Y-m-d')) }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date_fin">Date de fin (optionnel)</label>
                <input type="date" id="date_fin" name="date_fin" class="form-control"
                    value="{{ old('date_fin', $s?->date_fin?->format('Y-m-d')) }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="lieu">Lieu</label>
        <input type="text" id="lieu" name="lieu" class="form-control"
            value="{{ old('lieu', $s?->lieu) }}" placeholder="Ex : Ouagadougou - Campus principal">
    </div>

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