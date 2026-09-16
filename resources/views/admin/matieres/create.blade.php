{{-- resources/views/admin/matieres/create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle matière')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle matière</h3>
        </div>
        <form action="{{ route('admin.matieres.store') }}" method="POST">
            @csrf
            @include('admin.matieres.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer la matière</button>
                <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>