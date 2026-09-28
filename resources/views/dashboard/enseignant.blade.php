<x-admin>
    @section('title', 'Mon espace')

    @php($prenom = auth()->user()->personne?->prenom)

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bonjour{{ $prenom ? ', ' . $prenom : '' }} — Accès rapide</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.enseignant.notes.create') }}"
                       class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-upload"></i> Déposer une note
                    </a>
                    <a href="{{ route('admin.enseignant.notes.index') }}"
                       class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-folder-open"></i> Mes notes
                    </a>
                    <a href="{{ route('admin.informations.consulter') }}"
                       class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-bullhorn"></i> Toutes les informations
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @include('dashboard.partials.informations')
        </div>
    </div>
</x-admin>