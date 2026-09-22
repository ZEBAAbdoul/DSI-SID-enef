<x-admin>

@section('title', 'Modifier la recherche / innovation')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <p class="text-muted mb-0">
            Vous êtes en train de modifier :
            <strong class="text-dark">{{ $rechercheInnovation->titre }}</strong>
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
        action="{{ route('admin.recherches-innovations.update', $rechercheInnovation) }}"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row g-4">

                    @include('admin.recherches_innovations.partials.form', [
                        'rechercheInnovation' => $rechercheInnovation,
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
                    class="btn btn-primary"
                >

                    <i class="fas fa-save me-1"></i>

                    Enregistrer les modifications

                </button>

            </div>

        </div>

    </form>

</div>

</x-admin>