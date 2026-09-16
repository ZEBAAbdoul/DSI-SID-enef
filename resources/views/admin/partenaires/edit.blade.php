{{-- resources/views/admin/partenaires/edit.blade.php --}}
<x-admin>
    @section('title', 'Modifier le partenaire')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier le partenaire</h3>
        </div>
        <form id="edit-partenaire-form" action="{{ route('admin.partenaires.update', $partenaire) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="confirmer_echange" id="confirmer_echange" value="0">
            @include('admin.partenaires.partials.form')

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.partenaires.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('warning_echange'))
                var warning = @json(session('warning_echange'));
                Swal.fire({
                    title: 'Ordre déjà utilisé',
                    text: warning.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, échanger',
                    cancelButtonText: 'Annuler',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('confirmer_echange').value = '1';
                        document.getElementById('edit-partenaire-form').submit();
                    }
                });
            @endif
        });
    </script>
</x-admin>