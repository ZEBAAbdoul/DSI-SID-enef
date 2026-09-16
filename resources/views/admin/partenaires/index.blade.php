{{-- resources/views/admin/partenaires/index.blade.php --}}
<x-admin>
    @section('title', 'Partenaires')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Partenaires</h3>
            <div class="card-tools">
                <form action="{{ route('admin.partenaires.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher un partenaire…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.partenaires.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouveau partenaire
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ORDRE</th>
                            <th>LOGO</th>
                            <th>NOM</th>
                            <th>TYPE</th>
                            <th>SITE WEB</th>
                            <th>ACTIF</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($partenaires as $partenaire)
                            <tr>
                                <td>{{ $partenaire->ordre_affichage }}</td>
                                <td>
                                    @if ($partenaire->logo_url)
                                        <img src="{{ asset($partenaire->logo_url) }}" alt="{{ $partenaire->nom }}"
                                            style="max-height:35px;" class="border rounded p-1">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $partenaire->nom }}</td>
                                <td>{{ ucfirst($partenaire->type) }}</td>
                                <td>
                                    @if ($partenaire->site_web)
                                        <a href="{{ $partenaire->site_web }}" target="_blank" rel="noopener">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $partenaire->actif ? 'badge-primary' : 'badge-danger' }}">
                                        {{ $partenaire->actif ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                <a href="{{ route('admin.partenaires.show', $partenaire) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.partenaires.edit', $partenaire) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                    <form action="{{ route('admin.partenaires.destroy', $partenaire) }}" method="POST" style="display:inline-block;"
                                        class="delete-partenaire-form"
                                        data-partenaire-nom="{{ $partenaire->nom }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucun partenaire trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $partenaires->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status_partenaire'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: @json(session('status_partenaire')),
                    timer: 2500,
                    showConfirmButton: false,
                });
            @endif

            document.querySelectorAll('form.delete-partenaire-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const nom = form.getAttribute('data-partenaire-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer ce partenaire ?',
                        html: 'Le partenaire <strong>« ' + nom + ' »</strong> sera définitivement supprimé ainsi que son logo.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formToSubmit.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-admin>