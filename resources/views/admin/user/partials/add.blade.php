<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addUserForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Rôle</label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
