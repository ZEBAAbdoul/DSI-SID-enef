<x-admin>
    @section('title', 'Créer un utilisateur')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Créer un utilisateur</h3>
            <div class="card-tools">
                <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-dark">Retour</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom:*</label>
                            <input type="text" class="form-control" name="name" id="name" required
                                value="{{ old('name') }}">
                            <x-error field="name" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email:*</label>
                            <input type="email" class="form-control" name="email" id="email" required
                                value="{{ old('email') }}">
                            <x-error field="email" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe:*</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <x-error field="password" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="role" class="form-label">Rôle:*</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="" selected disabled>Sélectionnez le rôle</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $role->name == old('role') ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-error field="role" />
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="float-right">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin>
