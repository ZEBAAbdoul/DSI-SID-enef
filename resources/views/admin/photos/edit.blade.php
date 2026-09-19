
<x-admin>

    @section('title', 'Modifier une photo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Modifier la photo
            </h3>

        </div>


        <form
            action="{{ route('admin.photos.update', $photo) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="card-body">

                @include('admin.photos.partials.form')

            </div>

        </form>

    </div>

</x-admin>

