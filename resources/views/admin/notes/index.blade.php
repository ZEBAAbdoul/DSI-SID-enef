{{-- resources/views/admin/notes/index.blade.php --}}
<x-admin>
    @section('title', 'Saisie des notes')

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Saisie des notes</h3>
            <div class="card-tools">
                <form action="{{ route('admin.notes.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:160px;">
                        <select name="type_evaluation" class="form-control" onchange="this.form.submit()">
                            <option value="">Tous les types</option>
                            <option value="controle" {{ request('type_evaluation') === 'controle' ? 'selected' : '' }}>Contrôle</option>
                            <option value="examen" {{ request('type_evaluation') === 'examen' ? 'selected' : '' }}>Examen</option>
                            <option value="tp" {{ request('type_evaluation') === 'tp' ? 'selected' : '' }}>TP</option>
                            <option value="oral" {{ request('type_evaluation') === 'oral' ? 'selected' : '' }}>Oral</option>
                            <option value="projet" {{ request('type_evaluation') === 'projet' ? 'selected' : '' }}>Projet</option>
                        </select>
                    </div>
                </form>
                <form action="{{ route('admin.notes.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:160px;">
                        <select name="formation_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Toutes les formations</option>
                            @foreach ($formations as $f)
                                <option value="{{ $f->id }}" {{ request('formation_id') == $f->id ? 'selected' : '' }}>{{ $f->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <form action="{{ route('admin.notes.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher une note…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.notes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle note
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ÉLÈVE</th>
                            <th>FORMATION</th>
                            <th>MATIÈRE</th>
                            <th>TYPE</th>
                            <th>NOTE</th>
                            <th>NOTE /20</th>
                            <th>DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notes as $note)
                            <tr>
                                <td>{{ $note->eleve->name ?? '—' }}</td>
                                <td>{{ $note->formation->titre ?? '—' }}</td>
                                <td>{{ $note->matiere->nom ?? '—' }}</td>
                                <td>
                                    @switch($note->type_evaluation)
                                        @case('controle')
                                            <span class="badge badge-info">Contrôle</span>
                                            @break
                                        @case('examen')
                                            <span class="badge badge-danger">Examen</span>
                                            @break
                                        @case('tp')
                                            <span class="badge badge-primary">TP</span>
                                            @break
                                        @case('oral')
                                            <span class="badge badge-warning">Oral</span>
                                            @break
                                        @case('projet')
                                            <span class="badge badge-success">Projet</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <strong>{{ $note->note }}</strong> / {{ $note->note_max }}
                                </td>
                                <td>
                                    @php
                                        $sur20 = $note->note_sur_20;
                                        $color = $sur20 >= 10 ? 'success' : ($sur20 >= 8 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge badge-{{ $color }}">{{ $sur20 }}/20</span>
                                </td>
                                <td>{{ $note->date_evaluation?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.notes.destroy', $note) }}" method="POST" style="display:inline-block;"
                                        class="delete-note-form"
                                        data-note-eleve="{{ $note->eleve->name ?? '—' }}"
                                        data-note-matiere="{{ $note->matiere->nom ?? '—' }}">
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
                                <td colspan="8" class="text-center text-muted">Aucune note trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $notes->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-note-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const eleve = form.getAttribute('data-note-eleve');
                    const matiere = form.getAttribute('data-note-matiere');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette note ?',
                        text: 'La note de « ' + eleve + ' » en « ' + matiere + ' » sera définitivement supprimée.',
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
