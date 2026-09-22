
<x-admin>

    @section('title', 'Photos')

    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card">

        {{-- HEADER --}}
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-images mr-2"></i>
                Photos
            </h3>

            <div class="card-tools">

                <a
                    href="{{ route('admin.photos.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fas fa-plus"></i>
                    Nouvelle photo
                </a>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover mb-0"
                    width="100%"
                    cellspacing="0"
                >

                    <thead>

                        <tr>

                            <th style="width:60px;">
                                #
                            </th>

                            <th style="width:130px;">
                                IMAGE
                            </th>

                            <th>
                                TITRE
                            </th>

                            <th style="width:100px;">
                                ORDRE
                            </th>

                            <th style="width:120px;">
                                VISIBILITÉ
                            </th>

                            <th style="width:150px;">
                                ACTIONS
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($photos as $photo)

                            <tr>

                                {{-- Numéro --}}
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Image --}}
                                <td class="text-center">

                                    @if ($photo->image_url)

                                        <img
                                            src="{{ asset($photo->image_url) }}"
                                            alt="{{ $photo->titre }}"
                                            class="img-thumbnail"
                                            style="
                                                width:100px;
                                                height:70px;
                                                object-fit:cover;
                                                cursor: pointer;
                                            "
                                            onclick="openLightbox({{ $loop->index }})"
                                        >

                                    @else

                                        <i class="fas fa-image fa-2x text-muted"></i>

                                    @endif

                                </td>


                                {{-- Titre --}}
                                <td>

                                    <strong>
                                        <i class="fas fa-image text-primary mr-1"></i>
                                        {{ $photo->titre }}
                                    </strong>

                                    @if ($photo->description)

                                        <div class="text-muted small mt-1">
                                            {{ \Illuminate\Support\Str::limit($photo->description, 100) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Ordre --}}
                                <td class="text-center">
                                    {{ $photo->ordre }}
                                </td>


                                {{-- Visibilité --}}
                                <td class="text-center">

                                    @if ($photo->est_visible)

                                        <span class="badge badge-success">
                                            <i class="fas fa-eye mr-1"></i>
                                            Visible
                                        </span>

                                    @else

                                        <span class="badge badge-secondary">
                                            <i class="fas fa-eye-slash mr-1"></i>
                                            Masquée
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('admin.photos.show', $photo) }}"
                                        class="btn btn-sm btn-info"
                                        title="Voir"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- Modifier --}}
                                    <a
                                        href="{{ route('admin.photos.edit', $photo) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    {{-- Supprimer --}}
                                    <form
                                        action="{{ route('admin.photos.destroy', $photo) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-photo-form"
                                        data-photo-titre="{{ $photo->titre }}"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Supprimer"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="fas fa-images fa-2x mb-2"></i>

                                    <br>

                                    Aucune photo trouvée.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        @if ($photos instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="card-footer">
                {{ $photos->withQueryString()->links() }}
            </div>

        @endif

    </div>


    {{-- SWEETALERT --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-photo-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const titre = form.getAttribute(
                            'data-photo-titre'
                        );

                        Swal.fire({

                            title: 'Supprimer cette photo ?',

                            html:
                                'La photo <strong>« ' +
                                titre +
                                ' »</strong> sera définitivement supprimée.',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonColor: '#d33',

                            cancelButtonColor: '#6c757d',

                            confirmButtonText:
                                '<i class="fas fa-trash"></i> Oui, supprimer',

                            cancelButtonText:
                                'Annuler',

                        }).then(function (result) {

                            if (result.isConfirmed) {
                                form.submit();
                            }

                        });

                    });

                });

        });

    </script>

</x-admin>

<!-- Lightbox personnalisée avec navigation -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); z-index: 9999; justify-content: center; align-items: center;">
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 20px; background: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 24px; cursor: pointer; z-index: 10000;">&times;</button>
    
    <button onclick="navigateLightbox(-1)" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; color: white; cursor: pointer;">&#10094;</button>
    
    <div style="text-align: center; max-width: 90%; max-height: 90%;">
        <h3 id="lightboxTitle" style="color: white; margin-bottom: 10px;"></h3>
        <img id="lightboxImage" src="" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
        <p id="lightboxCounter" style="color: white; margin-top: 10px;"></p>
    </div>
    
    <button onclick="navigateLightbox(1)" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; color: white; cursor: pointer;">&#10095;</button>
</div>

<script>
window.currentPagePhotos = @json($photos->items());
window.currentPhotoIndex = 0;

function openLightbox(index) {
    window.currentPhotoIndex = index;
    const photo = window.currentPagePhotos[index];
    
    document.getElementById('lightboxTitle').textContent = photo.titre;
    document.getElementById('lightboxImage').src = '/storage/' + photo.image_url;
    document.getElementById('lightboxCounter').textContent = (index + 1) + ' / ' + window.currentPagePhotos.length;
    
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function navigateLightbox(direction) {
    const newIndex = (window.currentPhotoIndex + direction + window.currentPagePhotos.length) % window.currentPagePhotos.length;
    openLightbox(newIndex);
}

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            navigateLightbox(1);
        } else if (e.key === 'ArrowLeft') {
            navigateLightbox(-1);
        }
    }
});

// Fermer en cliquant sur le fond
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>

