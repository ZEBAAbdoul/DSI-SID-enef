<x-admin>

    @section('title', 'Détails de la catégorie')

    <div class="row">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations
                    </h3>

                </div>

                <div class="card-body">

                    <dl class="row">
                        <dt class="col-sm-4">Titre</dt>
                        <dd class="col-sm-8">{{ $categorie->titre }}</dd>

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $categorie->description ?? '-' }}</dd>

                        <dt class="col-sm-4">Ordre</dt>
                        <dd class="col-sm-8">{{ $categorie->ordre }}</dd>

                        <dt class="col-sm-4">Visible</dt>
                        <dd class="col-sm-8">
                            @if($categorie->est_visible)
                                <span class="badge badge-success">Oui</span>
                            @else
                                <span class="badge badge-danger">Non</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Photos</dt>
                        <dd class="col-sm-8">{{ $categorie->photos->count() }}</dd>
                    </dl>

                </div>

                <div class="card-footer">

                    <a href="{{ route('admin.categories-photos.edit', $categorie) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.categories-photos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-images mr-2"></i>
                        Photos ({{ $categorie->photos->count() }})
                    </h3>

                </div>

                <div class="card-body">

                    @if($categorie->photos->isEmpty())
                        <p class="text-center text-muted">Aucune photo dans cette catégorie</p>
                    @else
                        <div class="row">
                            @foreach($categorie->photos as $photo)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $photo->image_url) }}" class="card-img-top" alt="{{ $photo->titre }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 small">{{ $photo->titre }}</h6>
                                            <a href="{{ route('admin.photos.show', $photo) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</x-admin>