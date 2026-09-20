<x-admin>
    @section('title', 'Modifier le témoignage')

    @section('content')
        <div class="container-fluid py-4">
            <h1 class="h3 mb-4">Modifier le témoignage</h1>

            <form action="{{ route('admin.temoignages.update', $temoignage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.temoignages._form', ['submitLabel' => 'Mettre à jour'])
            </form>
        </div>
    </x-admin>
