{{-- resources/views/admin/filieres/create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle filière')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle filière</h3>
        </div>
        <form action="{{ route('admin.filieres.store') }}" method="POST">
            @csrf
            @include('admin.filieres.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer la filière</button>
                <a href="{{ route('admin.filieres.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
