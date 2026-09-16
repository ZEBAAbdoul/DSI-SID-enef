{{-- resources/views/admin/filieres/partials/form.blade.php --}}
@php
    $f = $filiere ?? null;
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

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nom">Nom de la filière <span class="text-danger">*</span></label>
                <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror"
                    maxlength="150" required
                    value="{{ old('nom', $f?->nom) }}" placeholder="Ex : Sciences Informatiques et de Gestion">
                @error('nom')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
                    maxlength="20"
                    value="{{ old('code', $f?->code) }}" placeholder="Ex : SIG">
                @error('code')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
            rows="3" placeholder="Description de la filière…">{{ old('description', $f?->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="responsable">Responsable</label>
                <input type="text" id="responsable" name="responsable" class="form-control @error('responsable') is-invalid @enderror"
                    maxlength="100"
                    value="{{ old('responsable', $f?->responsable) }}" placeholder="Nom du responsable">
                @error('responsable')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email_contact">Email de contact</label>
                <input type="email" id="email_contact" name="email_contact" class="form-control @error('email_contact') is-invalid @enderror"
                    maxlength="100"
                    value="{{ old('email_contact', $f?->email_contact) }}" placeholder="contact@exemple.com">
                @error('email_contact')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="hidden" name="est_active" value="0">
            <input type="checkbox" class="custom-control-input" id="est_active"
                name="est_active" value="1"
                {{ old('est_active', $f?->est_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="est_active">Filière active</label>
        </div>
    </div>
</div>
