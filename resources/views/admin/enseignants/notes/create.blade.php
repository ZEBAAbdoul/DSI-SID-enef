<x-admin title="Déposer des notes">

    <div class="container-fluid py-4">

        <h1 class="h4 mb-4">Déposer un fichier de notes</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form method="POST"
                      action="{{ route('admin.enseignant.notes.store') }}"
                      enctype="multipart/form-data">
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

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Formation <span class="text-danger">*</span></label>
                            <select name="formation_id" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                @foreach($formations as $formation)
                                    <option value="{{ $formation->id }}"
                                            @selected(old('formation_id') == $formation->id)>
                                        {{ $formation->titre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Session (optionnel)</label>
                            <select name="session_formation_id" class="form-select">
                                <option value="">Aucune session spécifique</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}"
                                            @selected(old('session_formation_id') == $session->id)>
                                        {{ $session->formation->titre ?? '—' }}
                                        — {{ \Carbon\Carbon::parse($session->date_debut)->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Matière <span class="text-danger">*</span></label>
                            <select name="matiere_id" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                            @selected(old('matiere_id') == $matiere->id)>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Type d'évaluation <span class="text-danger">*</span></label>
                            <select name="type_evaluation" class="form-select" required>
                                <option value="controle" @selected(old('type_evaluation') === 'controle')>Contrôle</option>
                                <option value="examen" @selected(old('type_evaluation') === 'examen')>Examen</option>
                                <option value="tp" @selected(old('type_evaluation') === 'tp')>TP</option>
                                <option value="oral" @selected(old('type_evaluation') === 'oral')>Oral</option>
                                <option value="projet" @selected(old('type_evaluation') === 'projet')>Projet</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Année <span class="text-danger">*</span></label>
                            <select name="annee" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                <option value="1" @selected(old('annee') == '1')>1ère année</option>
                                <option value="2" @selected(old('annee') == '2')>2ème année</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date de l'évaluation</label>
                            <input type="date" name="date_evaluation" class="form-control"
                                   value="{{ old('date_evaluation') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Commentaire (optionnel)</label>
                            <textarea name="commentaire" rows="2" class="form-control">{{ old('commentaire') }}</textarea>
                        </div>

                        <div class="col-12">
                            <hr>
                            <label class="form-label">Fichier <span class="text-danger">*</span></label>
                            <input type="file" name="fichier" accept=".xlsx,.xls,.csv,.pdf"
                                   class="form-control" required>
                            <div class="form-text">
                                Formats acceptés : Excel (.xlsx, .xls), CSV ou PDF — 10 Mo maximum.
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i>
                            Déposer le fichier
                        </button>
                        <a href="{{ route('admin.enseignant.notes.index') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-admin>