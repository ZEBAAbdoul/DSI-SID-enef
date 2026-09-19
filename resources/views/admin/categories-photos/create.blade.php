<x-admin>

    @section('title', 'Créer une catégorie')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-plus mr-2"></i>
                Nouvelle catégorie
            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.categories-photos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="titre">Titre *</label>
                    <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                    @error('titre')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ordre">Ordre</label>
                    <input type="number" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', 0) }}" min="0">
                    @error('ordre')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="est_visible" name="est_visible" value="1" checked>
                        <label class="custom-control-label" for="est_visible">Visible publiquement</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('admin.categories-photos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>

        </div>

    </div>

</x-admin>