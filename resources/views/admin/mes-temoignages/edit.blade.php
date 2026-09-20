<x-admin title="Modifier mon témoignage">
    <div class="container-fluid py-3">
        <h1 class="h3 mb-3">Modifier mon témoignage</h1>

        @if ($temoignage->est_publie)
            <div class="alert alert-warning">
                Ce témoignage est actuellement publié. Si vous le modifiez, il sera retiré du site jusqu'à sa nouvelle validation.
            </div>
        @endif

        <form action="{{ route('admin.mes-temoignages.update', $temoignage) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.mes-temoignages._form', ['submitLabel' => 'Enregistrer les modifications'])
        </form>
    </div>
</x-admin>