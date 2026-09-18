{{-- resources/views/admin/categories-documents/edit.blade.php --}}

<x-admin>

    @section('title', 'Modifier une catégorie de document')

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-7">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier la catégorie
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-secondary">
                            ID : {{ $categorie->id }}
                        </span>
                    </div>

                </div>

                <form
                    action="{{ route('admin.categories-documents.update', $categorie) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Veuillez corriger les erreurs suivantes.

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @include('admin.categories-documents.partials.form')

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-admin>
