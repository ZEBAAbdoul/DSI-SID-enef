{{-- resources/views/admin/categories-formation/partials/form.blade.php --}}
@php
    $c = $categorie ?? null;
@endphp

<div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="nom">Nom de la catégorie</label>
        <input type="text" id="nom" name="nom" class="form-control" maxlength="150" required
            value="{{ old('nom', $c?->nom) }}" placeholder="Ex : Bureautique">
    </div>
</div>
