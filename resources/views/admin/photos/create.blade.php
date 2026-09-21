

<x-admin>

    @section('title', 'Ajouter une photo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-image mr-2"></i>
                Ajouter une photo
            </h3>

        </div>


        <form
            action="{{ route('admin.photos.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="card-body">

                @include('admin.photos.partials.form')

            </div>

        </form>

    </div>

</x-admin>

