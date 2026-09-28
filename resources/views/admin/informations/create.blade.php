{{-- create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle information')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Nouvelle information</h3></div>
        <form action="{{ route('admin.informations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.informations.partials.form')
            <div class="card-footer">
                <a href="{{ route('admin.informations.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</x-admin>