<x-admin title="Modifier mon idée">
    <div class="container-fluid py-3">
        <h1 class="h3 mb-3">Modifier mon idée</h1>

        <form action="{{ route('admin.idees.update', $idee) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.idees._form', ['submitLabel' => 'Enregistrer les modifications'])
        </form>
    </div>
</x-admin>