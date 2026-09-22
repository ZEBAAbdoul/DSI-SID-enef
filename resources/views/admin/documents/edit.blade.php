<x-admin>

@section('title', 'Modifier — ' . $document->titre)

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- <h1 class="h3 mb-0">Modifier le document</h1> --}}
        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.documents.form')
            </form>
        </div>
    </div>

</div>
</x-admin>
