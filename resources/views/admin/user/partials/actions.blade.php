<div class="btn-group" role="group">
    <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>

    @role(['super-admin', 'admin'])
        @unless ($user->is(auth()->user()))
            <button type="button" class="btn btn-sm btn-outline-warning resetPasswordBtn" data-id="{{ $user->id }}"
                title="Réinitialiser le mot de passe">
                <i class="fas fa-key"></i>
            </button>
        @endunless
    @endrole

    {{-- <button class="btn btn-sm btn-danger deleteUserBtn"
            data-id="{{ $user->id }}"
            title="Supprimer">
        <i class="fas fa-trash"></i>
    </button> --}}
</div>
