<x-admin>

    @section('title', 'Modifier l’actualité')

    @section('content')

        <div class="container-fluid py-4">

            <div class="mb-4">

                <h1 class="h3 fw-bold">
                    Modifier l'actualité
                </h1>

                <p class="text-muted">
                    {{ $actualite->titre }}
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


            <form method="POST" action="{{ route('admin.actualites.update', $actualite) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')


                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Titre --}}
                            <div class="col-md-8">

                                <label class="form-label fw-bold">
                                    Titre *
                                </label>

                                <input type="text" name="titre" class="form-control"
                                    value="{{ old('titre', $actualite->titre) }}" required>

                            </div>


                            {{-- Type --}}
                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    Type *
                                </label>

                                <select name="type" class="form-select" required>

                                    @foreach ([
            'institutionnelle' => 'Institutionnelle',
            'formation' => 'Formation',
            'evenement' => 'Événement',
            'partenariat' => 'Partenariat',
            'communique' => 'Communiqué',
        ] as $key => $label)
                                        <option value="{{ $key }}" @selected(old('type', $actualite->type) === $key)>
                                            {{ $label }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            {{-- Chapo --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Chapo
                                </label>

                                <textarea name="chapo" rows="3" class="form-control">{{ old('chapo', $actualite->chapo) }}</textarea>

                            </div>


                            {{-- Contenu --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Contenu *
                                </label>

                                <textarea name="contenu" rows="12" class="form-control" required>{{ old('contenu', $actualite->contenu) }}</textarea>

                            </div>


                            {{-- Image actuelle --}}
                            <div class="col-md-6">

                                <label class="form-label fw-bold d-block">
                                    Image actuelle
                                </label>

                                <img src="{{ $actualite->image }}" alt="{{ $actualite->titre }}" class="img-thumbnail mb-3"
                                    style="max-height:180px;">

                                <label class="form-label fw-bold d-block">
                                    Remplacer l'image
                                </label>

                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">

                            </div>

                            {{-- Lien Facebook --}}
                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Lien Facebook
                                </label>

                                <input type="url" name="lien_facebook" class="form-control"
                                    value="{{ old('lien_facebook', $actualite->lien_facebook) }}"
                                    placeholder="https://www.facebook.com/...">

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
                                    value="{{ old('ordre_menu', $actualite->ordre_menu) }}" min="0">

                            </div>


                            {{-- Publication --}}
                            <div class="col-md-3">

                                <label class="form-label fw-bold d-block">
                                    Publication
                                </label>

                                <div class="form-check form-switch mt-2">

                                    <input type="checkbox" name="is_publiee" value="1" class="form-check-input"
                                        id="is_publiee" @checked(old('is_publiee', $actualite->is_publiee))>

                                    <label class="form-check-label" for="is_publiee">
                                        Publiée
                                    </label>

                                </div>

                            </div>


                            {{-- SEO --}}
                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Meta description
                                </label>

                                <textarea name="meta_description" rows="2" maxlength="160" class="form-control">{{ old('meta_description', $actualite->meta_description) }}</textarea>

                            </div>

                        </div>

                    </div>


                    <div class="card-footer bg-white d-flex justify-content-between">

                        <a href="{{ route('admin.actualites.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>

                            Enregistrer les modifications

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </x-admin>
