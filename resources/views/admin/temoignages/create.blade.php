<x-admin>
    @section('title', 'Nouveau témoignage')

    @section('content')
        <div class="container-fluid py-4">
            <h1 class="h3 mb-4">Nouveau témoignage</h1>

            <form action="{{ route('admin.temoignages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.temoignages._form', ['submitLabel' => 'Ajouter le témoignage'])
            </form>
        </div>
    @endsection
</x-admin>
