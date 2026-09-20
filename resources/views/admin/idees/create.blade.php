<x-admin title="Proposer une idée">
    <div class="container-fluid py-3">
        <h1 class="h3 mb-3">Proposer une idée</h1>

        <form action="{{ route('admin.idees.store') }}" method="POST">
            @csrf
            @include('admin.idees._form', ['submitLabel' => 'Envoyer mon idée'])
        </form>
    </div>
</x-admin>