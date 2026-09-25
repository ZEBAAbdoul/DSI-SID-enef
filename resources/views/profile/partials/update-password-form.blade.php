<x-admin>

    @section('title', 'Modifier le mot de passe')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key mr-2"></i>Changer mon mot de passe
                    </h3>
                </div>

                <form method="POST" action="{{ route('admin.profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success">
                                Votre mot de passe a été mis à jour avec succès.
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="current_password">Mot de passe actuel</label>
                            <input id="current_password" type="password" name="current_password"
                                class="form-control" autocomplete="current-password" required>
                            <x-input-error class="mt-2" field="current_password" />
                        </div>

                        <div class="form-group">
                            <label for="password">Nouveau mot de passe</label>
                            <input id="password" type="password" name="password" class="form-control"
                                autocomplete="new-password" required minlength="12"
                                placeholder="12 caractères minimum">
                            <x-input-error class="mt-2" field="password" />
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control" autocomplete="new-password" required minlength="12"
                                placeholder="Répétez le nouveau mot de passe">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin>