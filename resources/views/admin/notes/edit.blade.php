{{-- resources/views/admin/notes/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier la note')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la note</h3>
        </div>
        <form action="{{ route('admin.notes.update', $note) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.notes.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
