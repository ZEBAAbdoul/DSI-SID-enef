<x-admin title="Ajouter une unité pédagogique">

    <div class="container-fluid py-4">

        <h1 class="h4 mb-4">Ajouter une unité pédagogique</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.unites-pedagogiques.store') }}"
                    enctype="multipart/form-data">
                    @include('admin.unites-pedagogiques.form')

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('admin.unites-pedagogiques.index') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin>