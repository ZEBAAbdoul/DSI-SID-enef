{{-- resources/views/admin/types-pieces/create.blade.php --}}
<x-admin>
    @section('title', 'Nouveau type de pièce')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouveau type de pièce</h3>
        </div>
        <form action="{{ route('admin.types-pieces.store') }}" method="POST">
            @csrf
            @include('admin.types-pieces.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer le type de pièce</button>
                <a href="{{ route('admin.types-pieces.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>