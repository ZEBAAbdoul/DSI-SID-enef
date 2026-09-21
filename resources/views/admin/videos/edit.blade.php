

<x-admin>

    @section('title', 'Modifier une vidéo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-edit mr-2"></i>

                Modifier la vidéo

            </h3>

        </div>


        <form
            action="{{ route('admin.videos.update', $video) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="card-body">

                @include('admin.videos.partials.form')

            </div>

        </form>

    </div>

</x-admin>

