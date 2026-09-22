<x-admin>
    <x-slot name="title">Modifier une information</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Modifier une information</h1>
        <a href="{{ route('admin.formation-informations.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.formation-informations.update', $information) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- @include('formation-informations._form') --}}

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.formation-informations.index') }}" class="btn btn-link">Annuler</a>
            </form>
        </div>
    </div>
</x-admin>