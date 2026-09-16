<x-admin>
    @section('title', 'Modifier la formation')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier la formation
                </h3>
            </div>

            <form action="{{ route('admin.formations.update', $formation) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Veuillez corriger les erreurs suivantes :
                            </strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">

                        {{-- Type --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Type <span class="text-danger">*</span>
                                </label>

                                <select name="type"
                                        class="form-control"
                                        required>

                                    <option value="academique"
                                        {{ old('type', $formation->type) == 'academique' ? 'selected' : '' }}>
                                        Académique
                                    </option>

                                    <option value="continue_programmee"
                                        {{ old('type', $formation->type) == 'continue_programmee' ? 'selected' : '' }}>
                                        Continue Programmée
                                    </option>

                                    <option value="continue_a_la_carte"
                                        {{ old('type', $formation->type) == 'continue_a_la_carte' ? 'selected' : '' }}>
                                        Continue à la Carte
                                    </option>

                                </select>

                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Statut --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Statut <span class="text-danger">*</span>
                                </label>

                                <select name="statut"
                                        class="form-control"
                                        required>

                                    <option value="brouillon"
                                        {{ old('statut', $formation->statut) == 'brouillon' ? 'selected' : '' }}>
                                        Brouillon
                                    </option>

                                    <option value="ouverte"
                                        {{ old('statut', $formation->statut) == 'ouverte' ? 'selected' : '' }}>
                                        Ouverte
                                    </option>

                                    <option value="cloturee"
                                        {{ old('statut', $formation->statut) == 'cloturee' ? 'selected' : '' }}>
                                        Clôturée
                                    </option>

                                </select>

                                @error('statut')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Titre --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Titre <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="titre"
                                       value="{{ old('titre', $formation->titre) }}"
                                       class="form-control"
                                       required>

                                @error('titre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Filière --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filière</label>

                                <select name="filiere_id"
                                        class="form-control">

                                    <option value="">
                                        -- Aucune filière --
                                    </option>

                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}"
                                            {{ old('filiere_id', $formation->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Catégorie <span class="text-danger">*</span>
                                </label>

                                <select name="categorie_id"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        -- Sélectionner --
                                    </option>

                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id', $formation->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Résumé</label>

                                <textarea name="resume"
                                          rows="3"
                                          class="form-control">{{ old('resume', $formation->resume) }}</textarea>
                            </div>
                        </div>

                        {{-- Objectifs --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Objectifs</label>

                                <textarea name="objectifs"
                                          rows="5"
                                          class="form-control">{{ old('objectifs', $formation->objectifs) }}</textarea>
                            </div>
                        </div>

                        {{-- Contenu --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contenu du programme</label>

                                <textarea name="contenu_programme"
                                          rows="5"
                                          class="form-control">{{ old('contenu_programme', $formation->contenu_programme) }}</textarea>
                            </div>
                        </div>

                        {{-- Durée --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Durée</label>

                                <input type="text"
                                       name="duree"
                                       value="{{ old('duree', $formation->duree) }}"
                                       class="form-control">
                            </div>
                        </div>

                        {{-- Coût --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coût indicatif (FCFA)</label>

                                <input type="number"
                                       name="cout_indicatif"
                                       value="{{ old('cout_indicatif', $formation->cout_indicatif) }}"
                                       min="0"
                                       step="0.01"
                                       class="form-control">
                            </div>
                        </div>

                        {{-- Public cible --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Public cible</label>

                                <textarea name="public_cible"
                                          rows="3"
                                          class="form-control">{{ old('public_cible', $formation->public_cible) }}</textarea>
                            </div>
                        </div>

                        {{-- Mots-clés --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mots-clés</label>

                                <input type="text"
                                       name="mots_cles"
                                       value="{{ old('mots_cles', $formation->mots_cles) }}"
                                       class="form-control">

                                <small class="form-text text-muted">
                                    Séparez les mots-clés par des virgules.
                                </small>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Image</label>

                                @if ($formation->image_url)
                                    <div class="mb-2">
                                        <img src="{{ asset($formation->image_url) }}"
                                             alt="{{ $formation->titre }}"
                                             class="img-thumbnail"
                                             style="max-height: 150px;">
                                    </div>
                                @endif

                                <input type="file"
                                       name="image"
                                       class="form-control-file"
                                       accept=".jpg,.jpeg,.png,.webp">

                                <small class="form-text text-muted">
                                    Laisser vide pour conserver l'image actuelle.
                                </small>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <a href="{{ route('admin.formations.index') }}"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Annuler
                    </a>

                    <button type="submit"
                            class="btn btn-primary float-right">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </div>
</x-admin>