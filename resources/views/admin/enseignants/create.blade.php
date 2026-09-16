<x-admin title="Nouvel enseignant">
    <div class="container-fluid py-4">
        <h1 class="h4 mb-4">Nouvel enseignant</h1>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.enseignants.store') }}">
                    @include('admin.enseignants._form', ['enseignant' => null])
                </form>
            </div>
        </div>
    </div>
</x-admin>