{{-- edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier l\'information')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Modifier l'information</h3></div>
        <form action="{{ route('admin.informations.update', $information) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.informations.partials.form')
            <div class="card-footer">
                <a href="{{ route('admin.informations.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</x-admin>