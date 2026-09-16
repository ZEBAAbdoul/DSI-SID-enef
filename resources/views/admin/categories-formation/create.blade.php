{{-- resources/views/admin/categories-formation/create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle catégorie de formation')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle catégorie de formation</h3>
        </div>
        <form action="{{ route('admin.categories-formation.store') }}" method="POST">
            @csrf
            @include('admin.categories-formation.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer la catégorie</button>
                <a href="{{ route('admin.categories-formation.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
