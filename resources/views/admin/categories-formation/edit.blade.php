{{-- resources/views/admin/categories-formation/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier la catégorie de formation')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la catégorie de formation</h3>
        </div>
        <form action="{{ route('admin.categories-formation.update', $categorie) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.categories-formation.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.categories-formation.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
