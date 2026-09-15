{{-- resources/views/admin/sessions-formation/create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle session de formation')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle session de formation</h3>
        </div>
        <form action="{{ route('admin.sessions-formation.store') }}" method="POST">
            @csrf
            @include('admin.sessions-formation.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Créer la session</button>
                <a href="{{ route('admin.sessions-formation.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>