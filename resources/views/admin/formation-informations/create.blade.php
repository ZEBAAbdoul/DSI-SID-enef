<x-admin>
    <x-slot name="title">Ajouter une information</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Ajouter une information</h1>
        <a href="{{ route('admin.formation-informations.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.formation-informations.store') }}" method="POST">
                @csrf
                @include('admin.formation-informations._form')

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.formation-informations.index') }}" class="btn btn-link">Annuler</a>
            </form>
        </div>
    </div>
</x-admin>