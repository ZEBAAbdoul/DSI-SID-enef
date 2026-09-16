{{-- resources/views/admin/notes/create.blade.php --}}
<x-admin>
    @section('title', 'Nouvelle note')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle note</h3>
        </div>
        <form action="{{ route('admin.notes.store') }}" method="POST">
            @csrf
            @include('admin.notes.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer la note</button>
                <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-admin>
