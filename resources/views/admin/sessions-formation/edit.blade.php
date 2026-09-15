{{-- resources/views/admin/sessions-formation/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier la session')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la session</h3>
        </div>
        <form action="{{ route('admin.sessions-formation.update', $session) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.sessions-formation.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.sessions-formation.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>