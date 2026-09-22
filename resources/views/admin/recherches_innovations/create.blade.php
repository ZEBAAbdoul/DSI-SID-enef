<x-admin>

@section('title', 'Nouvelle recherche / innovation')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <p class="text-muted mb-0">
            Ajouter une recherche ou une innovation à mettre en avant sur le site de l'ENEF.
        </p>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('admin.recherches-innovations.store') }}"
        enctype="multipart/form-data"
    >

        @csrf


        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row g-4">

                    @include('admin.recherches_innovations.partials.form', [
                        'rechercheInnovation' => null,
                    ])

                </div>

            </div>


            <div class="card-footer bg-white d-flex justify-content-between">

                <a
                    href="{{ route('admin.recherches-innovations.index') }}"
                    class="btn btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="fas fa-save me-1"></i>

                    Enregistrer

                </button>

            </div>

        </div>

    </form>

</div>

</x-admin>