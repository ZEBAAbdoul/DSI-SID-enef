{{-- resources/views/admin/partenaires/create.blade.php --}}
<x-admin>
    @section('title', 'Nouveau partenaire')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouveau partenaire</h3>
        </div>
        <form action="{{ route('admin.partenaires.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.partenaires.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer le partenaire</button>
                <a href="{{ route('admin.partenaires.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>