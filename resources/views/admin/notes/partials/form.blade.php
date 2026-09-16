{{-- resources/views/admin/notes/partials/form.blade.php --}}
@php
    $n = $note ?? null;
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="eleve_id">Élève <span class="text-danger">*</span></label>
                <select id="eleve_id" name="eleve_id" class="form-control @error('eleve_id') is-invalid @enderror" required>
                    <option value="">— Sélectionner un élève —</option>
                    @foreach ($eleves as $eleve)
                        <option value="{{ $eleve->id }}" {{ old('eleve_id', $n?->eleve_id) == $eleve->id ? 'selected' : '' }}>
                            {{ $eleve->name ?? $eleve->email }}
                        </option>
                    @endforeach
                </select>
                @error('eleve_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="enseignant_id">Enseignant <span class="text-danger">*</span></label>
                <select id="enseignant_id" name="enseignant_id" class="form-control @error('enseignant_id') is-invalid @enderror" required>
                    <option value="">— Sélectionner un enseignant —</option>
                    @foreach ($enseignants as $ens)
                        <option value="{{ $ens->id }}" {{ old('enseignant_id', $n?->enseignant_id) == $ens->id ? 'selected' : '' }}>
                            {{ $ens->user->name ?? '—' }} ({{ $ens->matricule ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('enseignant_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="formation_id">Formation <span class="text-danger">*</span></label>
                <select id="formation_id" name="formation_id" class="form-control @error('formation_id') is-invalid @enderror" required>
                    <option value="">— Sélectionner une formation —</option>
                    @foreach ($formations as $f)
                        <option value="{{ $f->id }}" {{ old('formation_id', $n?->formation_id) == $f->id ? 'selected' : '' }}>
                            {{ $f->titre }}
                        </option>
                    @endforeach
                </select>
                @error('formation_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="matiere_id">Matière <span class="text-danger">*</span></label>
                <select id="matiere_id" name="matiere_id" class="form-control @error('matiere_id') is-invalid @enderror" required>
                    <option value="">— Sélectionner une matière —</option>
                    @foreach ($matieres as $m)
                        <option value="{{ $m->id }}" {{ old('matiere_id', $n?->matiere_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->nom }} ({{ $m->code ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('matiere_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="type_evaluation">Type d'évaluation <span class="text-danger">*</span></label>
                <select id="type_evaluation" name="type_evaluation" class="form-control @error('type_evaluation') is-invalid @enderror" required>
                    <option value="controle" {{ old('type_evaluation', $n?->type_evaluation ?? 'controle') === 'controle' ? 'selected' : '' }}>Contrôle</option>
                    <option value="examen" {{ old('type_evaluation', $n?->type_evaluation) === 'examen' ? 'selected' : '' }}>Examen</option>
                    <option value="tp" {{ old('type_evaluation', $n?->type_evaluation) === 'tp' ? 'selected' : '' }}>TP</option>
                    <option value="oral" {{ old('type_evaluation', $n?->type_evaluation) === 'oral' ? 'selected' : '' }}>Oral</option>
                    <option value="projet" {{ old('type_evaluation', $n?->type_evaluation) === 'projet' ? 'selected' : '' }}>Projet</option>
                </select>
                @error('type_evaluation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="session_formation_id">Session</label>
                <select id="session_formation_id" name="session_formation_id" class="form-control @error('session_formation_id') is-invalid @enderror">
                    <option value="">— Aucune session —</option>
                    @foreach ($sessions as $s)
                        <option value="{{ $s->id }}" {{ old('session_formation_id', $n?->session_formation_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->formation->titre ?? '' }} — {{ $s->date_debut?->format('d/m/Y') }} → {{ $s->date_fin?->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
                @error('session_formation_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_evaluation">Date d'évaluation</label>
                <input type="date" id="date_evaluation" name="date_evaluation" class="form-control @error('date_evaluation') is-invalid @enderror"
                    value="{{ old('date_evaluation', $n?->date_evaluation?->format('Y-m-d')) }}">
                @error('date_evaluation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="note">Note obtenue <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" id="note" name="note" class="form-control @error('note') is-invalid @enderror"
                    value="{{ old('note', $n?->note) }}" required placeholder="Ex : 14.50">
                @error('note')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="note_max">Note maximale</label>
                <input type="number" step="0.01" min="1" id="note_max" name="note_max" class="form-control @error('note_max') is-invalid @enderror"
                    value="{{ old('note_max', $n?->note_max ?? 20) }}">
                @error('note_max')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Équivalence /20</label>
                <input type="text" class="form-control" disabled readonly id="note-sur-20"
                    value="{{ $n ? $n->note_sur_20 : '—' }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" name="commentaire" class="form-control @error('commentaire') is-invalid @enderror"
            rows="2" placeholder="Commentaire optionnel…">{{ old('commentaire', $n?->commentaire) }}</textarea>
        @error('commentaire')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const noteInput = document.getElementById('note');
        const noteMaxInput = document.getElementById('note_max');
        const sur20Display = document.getElementById('note-sur-20');

        function calculerSur20() {
            const note = parseFloat(noteInput.value) || 0;
            const noteMax = parseFloat(noteMaxInput.value) || 20;
            if (noteMax > 0) {
                sur20Display.value = (note / noteMax * 20).toFixed(2) + '/20';
            }
        }

        if (noteInput) noteInput.addEventListener('input', calculerSur20);
        if (noteMaxInput) noteMaxInput.addEventListener('input', calculerSur20);
    });
</script>
@endpush
