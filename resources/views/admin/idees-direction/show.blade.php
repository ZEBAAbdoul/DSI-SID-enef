<x-admin title="Détail de l'idée">
    <div class="container-fluid py-3">
        <a href="{{ route('admin.idees-direction.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2">{{ $idee->titre }}</h4>
                        <div class="mb-3">
                            <span class="badge badge-{{ $idee->statut_badge }}">{{ $idee->statut_libelle }}</span>
                            @if ($idee->categorie_libelle)
                                <span class="badge badge-light border ml-1">{{ $idee->categorie_libelle }}</span>
                            @endif
                        </div>
                        <p style="white-space:pre-line;">{{ $idee->description }}</p>
                        <hr>
                        <small class="text-muted">
                            Proposée par <strong>{{ $idee->auteur_nom }}</strong>
                            le {{ $idee->created_at?->format('d/m/Y à H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><strong>Traitement</strong></div>
                    <div class="card-body">
                        <form action="{{ route('admin.idees-direction.update', $idee) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="statut">Statut</label>
                                <select id="statut" name="statut" class="form-control">
                                    @foreach (\App\Models\Idee::STATUTS as $cle => $s)
                                        <option value="{{ $cle }}" @selected(old('statut', $idee->statut) === $cle)>{{ $s['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reponse">Réponse à l'auteur</label>
                                <textarea id="reponse" name="reponse" rows="5" maxlength="1000" class="form-control"
                                    placeholder="Facultatif : explication, remerciement, prochaines étapes…">{{ old('reponse', $idee->reponse) }}</textarea>
                                <small class="form-text text-muted">Visible par l'auteur de l'idée.</small>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Enregistrer</button>
                        </form>

                        @if ($idee->traitee_le)
                            <small class="text-muted d-block mt-3">
                                Dernier traitement le {{ $idee->traitee_le->format('d/m/Y') }}
                                @if ($idee->traiteePar) par {{ $idee->traiteePar->personne?->prenom ?? $idee->traiteePar->email }} @endif
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>