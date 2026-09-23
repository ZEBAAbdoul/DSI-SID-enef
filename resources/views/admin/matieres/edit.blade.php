{{-- resources/views/admin/matieres/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier la matière')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la matière</h3>
        </div>
        <form action="{{ route('admin.matieres.update', $matiere) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.matieres.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>