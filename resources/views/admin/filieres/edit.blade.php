{{-- resources/views/admin/filieres/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier la filière')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la filière</h3>
        </div>
        <form action="{{ route('admin.filieres.update', $filiere) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.filieres.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.filieres.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
