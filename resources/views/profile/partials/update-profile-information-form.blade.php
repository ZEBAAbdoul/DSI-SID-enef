<x-admin>

    @section('title', 'Mon profil')

    <section>
        <header>
            {{-- <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2> --}}

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Mettez à jour les informations de profil et l'adresse e-mail de votre compte.") }}
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="mb-3">
                <x-input-label for="nom" class="form-label" :value="__('Nom')" />
                <x-text-input id="nom" name="nom" type="text" class="form-control"
                    :value="old('nom', $user->personne?->nom)" required autofocus autocomplete="family-name" />
                <x-input-error class="mt-2" field="nom" />
            </div>

            <div class="mb-3">
                <x-input-label for="prenom" class="form-label" :value="__('Prénom')" />
                <x-text-input id="prenom" name="prenom" type="text" class="form-control"
                    :value="old('prenom', $user->personne?->prenom)" required autocomplete="given-name" />
                <x-input-error class="mt-2" field="prenom" />
            </div>

            {{-- <div class="mb-3">
                <x-input-label for="Mode" class="form-label" :value="__('Mode')" />
                <select name="mode" id="Mode" class="form-control">
                    <option {{ old('mode', Auth::user()->mode) == 'dark' ? 'selected' : '' }} value="dark">Dark
                    </option>
                    <option {{ old('mode', Auth::user()->mode) == 'light' ? 'selected' : '' }} value="light">Light
                    </option>
                </select>
                <x-input-error class="mt-2" field="mode" />
            </div> --}}

            <div class="mb-3">
                <x-input-label for="email" class="form-label" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="form-control"
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" field="email" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <a href="{{ route('admin.profile.password.edit') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-key mr-1"></i> {{ __('Modifier le mot de passe') }}
                </a>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-primary btn-sm">{{ __('Enregistrer') }}</button>
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ 'Saved' }}
                        <button type="button" class="btn btn-sm float-end float-right" data-bs-dismiss="alert"
                            aria-label="Close">&times;</button>
                    </div>
                @endif
            </div>
        </form>
    </section>

</x-admin>