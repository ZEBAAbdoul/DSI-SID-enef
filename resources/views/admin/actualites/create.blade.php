<x-admin>

    @section('title', 'Nouvelle actualité')

    @section('content')

        <div class="container-fluid py-4">

            <div class="mb-4">

                <h1 class="h3 fw-bold">
                    Nouvelle actualité
                </h1>

                <p class="text-muted">
                    Publier une nouvelle information sur le site de l'ENEF.
                </p>

            </div>


            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <form method="POST" action="{{ route('admin.actualites.store') }}" enctype="multipart/form-data">

                @csrf


                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Titre --}}
                            <div class="col-md-8">

                                <label class="form-label fw-bold">
                                    Titre *
                                </label>

                                <input type="text" name="titre" class="form-control" value="{{ old('titre') }}"
                                    required>

                            </div>


                            {{-- Type --}}
                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    Type *
                                </label>

                                <select name="type" class="form-select" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="institutionnelle">
                                        Institutionnelle
                                    </option>

                                    <option value="formation">
                                        Formation
                                    </option>

                                    <option value="evenement">
                                        Événement
                                    </option>

                                    <option value="partenariat">
                                        Partenariat
                                    </option>

                                    <option value="communique">
                                        Communiqué
                                    </option>

                                </select>

                            </div>


                            {{-- Chapo --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Chapo
                                </label>

                                <textarea name="chapo" rows="3" class="form-control" maxlength="1000">{{ old('chapo') }}</textarea>

                                <small class="text-muted">
                                    Résumé court de l'actualité.
                                </small>

                            </div>


                            {{-- Contenu --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Contenu *
                                </label>

                                <textarea name="contenu" rows="12" class="form-control" required>{{ old('contenu') }}</textarea>

                            </div>


                            {{-- Image --}}
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Image de couverture
                                </label>

                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">

                                <small class="text-muted">
                                    JPG, PNG ou WEBP — maximum 4 Mo.
                                </small>

                            </div>

                            {{-- Lien Facebook --}}
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Lien Facebook
                                </label>

                                <input type="url" name="lien_facebook" class="form-control"
                                    value="{{ old('lien_facebook') }}" placeholder="https://www.facebook.com/...">

                                <small class="text-muted">
                                    URL de la publication ou page Facebook liée à cette actualité.
                                </small>

                            </div>


                            {{-- Ordre --}}
                            <div class="col-md-3">

                                <label class="form-label fw-bold">
                                    Ordre
                                </label>

                                <input type="number" name="ordre_menu" class="form-control"
                                    value="{{ old('ordre_menu', 0) }}" min="0">

                            </div>


                            {{-- Publication --}}
                            <div class="col-md-3">

                                <label class="form-label fw-bold d-block">
                                    Publication
                                </label>

                                <div class="form-check form-switch mt-2">

                                    <input type="checkbox" name="is_publiee" value="1" class="form-check-input"
                                        id="is_publiee">

                                    <label class="form-check-label" for="is_publiee">
                                        Publier immédiatement
                                    </label>

                                </div>

                            </div>


                            {{-- SEO --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Meta description
                                </label>

                                <textarea name="meta_description" rows="2" maxlength="160" class="form-control">{{ old('meta_description') }}</textarea>

                            </div>

                        </div>

                    </div>


                    <div class="card-footer bg-white d-flex justify-content-between">

                        <a href="{{ route('admin.actualites.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save me-1"></i>

                            Enregistrer

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </x-admin>
