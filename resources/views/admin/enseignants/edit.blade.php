<x-admin title="Modifier l'enseignant">
    <div class="container-fluid py-4">
        <h1 class="h4 mb-4">Modifier l'enseignant</h1>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.enseignants.update', $enseignant) }}">
                    @method('PUT')
                    @include('admin.enseignants._form')
                </form>
            </div>
        </div>
    </div>
</x-admin>