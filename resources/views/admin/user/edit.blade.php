{{-- resources/views/admin/user/edit.blade.php --}}
<x-admin title="Modifier un utilisateur">

    <div class="container-fluid py-3">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h4 mb-1">Modifier l'utilisateur</h1>
                <p class="text-muted mb-0">{{ $user->name ?? '—' }} — {{ $user->email }}</p>
            </div>

            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>

        {{-- Compte créé sans état civil (ancien compte) --}}
        @unless ($user->personne)
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-info-circle me-1"></i>
                Ce compte n'a pas encore d'état civil. Renseignez-le ci-dessous : il sera créé à l'enregistrement.
            </div>
        @endunless

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong><i class="fas fa-exclamation-triangle me-1"></i> Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.user.update', $user) }}" method="POST" id="userForm">
            @csrf
            @method('PUT')

            @include('admin.user.partials.form')

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Annuler</a>

                <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
                    <i class="fas fa-save me-1"></i>
                    <span id="btnSubmitLabel">Enregistrer les modifications</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Anti double-clic à l'envoi
        (function() {
            var form = document.getElementById('userForm');
            var btn = document.getElementById('btnSubmit');
            form.addEventListener('submit', function() {
                if (!form.checkValidity()) return;
                btn.disabled = true;
                document.getElementById('btnSubmitLabel').textContent = 'Enregistrement…';
            });
        })();
    </script>
</x-admin>