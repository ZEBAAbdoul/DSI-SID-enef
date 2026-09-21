

<x-admin>

    @section('title', 'Ajouter une vidéo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-video mr-2"></i>

                Ajouter une vidéo

            </h3>

        </div>


        <form
            action="{{ route('admin.videos.store') }}"
            method="POST"
        >

            @csrf

            <div class="card-body">

                @include('admin.videos.partials.form')

            </div>

        </form>

    </div>

</x-admin>

