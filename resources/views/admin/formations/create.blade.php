<x-admin>
    @section('title', 'Nouvelle formation')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer une nouvelle formation
                </h3>
            </div>

            <form action="{{ route('admin.formations.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

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
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Type <span class="text-danger">*</span>
                                </label>

                                <select name="type"
                                        class="form-control @error('type') is-invalid @enderror"
                                        required>

                                    <option value="">-- Sélectionner --</option>

                                    <option value="academique"
                                        {{ old('type') == 'academique' ? 'selected' : '' }}>
                                        Académique
                                    </option>

                                    <option value="continue_programmee"
                                        {{ old('type') == 'continue_programmee' ? 'selected' : '' }}>
                                        Continue Programmée
                                    </option>

                                    <option value="continue_a_la_carte"
                                        {{ old('type') == 'continue_a_la_carte' ? 'selected' : '' }}>
                                        Continue à la Carte
                                    </option>

                                </select>

                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Catégorie
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="categorie_id"
                                        class="form-control @error('categorie_id') is-invalid @enderror"
                                        required>

                                    <option value="">-- Sélectionner --</option>

                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('categorie_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
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
                                        class="form-control @error('statut') is-invalid @enderror"
                                        required>

                                    <option value="brouillon"
                                        {{ old('statut') == 'brouillon' ? 'selected' : '' }}>
                                        Brouillon
                                    </option>

                                    <option value="ouverte"
                                        {{ old('statut', 'ouverte') == 'ouverte' ? 'selected' : '' }}>
                                        Ouverte
                                    </option>

                                    <option value="cloturee"
                                        {{ old('statut') == 'cloturee' ? 'selected' : '' }}>
                                        Clôturée
                                    </option>

                                </select>

                                @error('statut')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Titre --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Titre de la formation
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="titre"
                                       value="{{ old('titre') }}"
                                       class="form-control @error('titre') is-invalid @enderror"
                                       placeholder="Ex : Formation en gestion forestière"
                                       required>

                                @error('titre')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Filière --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filière</label>

                                <select name="filiere_id"
                                        class="form-control @error('filiere_id') is-invalid @enderror">

                                    <option value="">-- Aucune filière --</option>

                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}"
                                            {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('filiere_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Catégorie
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="categorie_id"
                                        class="form-control @error('categorie_id') is-invalid @enderror"
                                        required>

                                    <option value="">-- Sélectionner --</option>

                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('categorie_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- Résumé --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Résumé</label>

                                <textarea name="resume"
                                          rows="3"
                                          class="form-control @error('resume') is-invalid @enderror"
                                          placeholder="Présentez brièvement la formation...">{{ old('resume') }}</textarea>

                                @error('resume')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Objectifs --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Objectifs</label>

                                <textarea name="objectifs"
                                          rows="5"
                                          class="form-control @error('objectifs') is-invalid @enderror"
                                          placeholder="Objectifs de la formation...">{{ old('objectifs') }}</textarea>

                                @error('objectifs')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Contenu --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contenu du programme</label>

                                <textarea name="contenu_programme"
                                          rows="5"
                                          class="form-control @error('contenu_programme') is-invalid @enderror"
                                          placeholder="Contenu et programme de la formation...">{{ old('contenu_programme') }}</textarea>

                                @error('contenu_programme')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Durée --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Durée</label>

                                <input type="text"
                                       name="duree"
                                       value="{{ old('duree') }}"
                                       class="form-control @error('duree') is-invalid @enderror"
                                       placeholder="Ex : 3 mois, 120 heures">

                                @error('duree')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Coût --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coût indicatif (FCFA)</label>

                                <input type="number"
                                       name="cout_indicatif"
                                       value="{{ old('cout_indicatif') }}"
                                       min="0"
                                       step="0.01"
                                       class="form-control @error('cout_indicatif') is-invalid @enderror"
                                       placeholder="Ex : 150000">

                                @error('cout_indicatif')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Public cible --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Public cible</label>

                                <textarea name="public_cible"
                                          rows="3"
                                          class="form-control @error('public_cible') is-invalid @enderror"
                                          placeholder="À qui s'adresse cette formation ?">{{ old('public_cible') }}</textarea>

                                @error('public_cible')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Mots clés --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mots-clés</label>

                                <input type="text"
                                       name="mots_cles"
                                       value="{{ old('mots_cles') }}"
                                       class="form-control @error('mots_cles') is-invalid @enderror"
                                       placeholder="Forêt, environnement, gestion">

                                <small class="form-text text-muted">
                                    Séparez les mots-clés par des virgules.
                                </small>

                                @error('mots_cles')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image de la formation</label>

                                <input type="file"
                                       name="image"
                                       class="form-control-file @error('image') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.webp">

                                <small class="form-text text-muted">
                                    JPG, PNG ou WEBP — 5 Mo maximum.
                                </small>

                                @error('image')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
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
                        Enregistrer la formation
                    </button>

                </div>

            </form>

        </div>

    </div>
</x-admin>
