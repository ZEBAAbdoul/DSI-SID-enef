<x-admin title="Écrire un témoignage">
    <div class="container-fluid py-3">
        <h1 class="h3 mb-3">Écrire un témoignage</h1>

        <form action="{{ route('admin.mes-temoignages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.mes-temoignages._form', ['submitLabel' => 'Envoyer mon témoignage'])
        </form>
    </div>
</x-admin>