<x-guest-layout>
    @section('title')
        {{ 'Log in' }}
    @endsection
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="brand-link d-flex flex-column align-items-center justify-content-center"
                    style="min-height: 100px;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo ENEF"
                        class="brand-logo-img" style="max-height: 80px; width: auto;">
                    <span class="brand-name mt-2">ENEF</span>
                    <span class="brand-subtitle">École Nationale des Eaux et Forêts</span>
                </a>

                <style>
                    .brand-name {
                        font-family: 'Poppins', sans-serif;
                        font-size: 1.4rem;
                        font-weight: 700;
                        color: #2e7d32;
                        letter-spacing: 1px;
                    }

                    .brand-subtitle {
                        font-family: 'Poppins', sans-serif;
                        font-size: 0.85rem;
                        color: #555;
                        font-style: italic;
                    }

                    .brand-logo-img {
                        transition: transform 0.3s ease;
                    }

                    .brand-link:hover .brand-logo-img {
                        transform: scale(1.05);
                    }

                    .form-label {
                        font-weight: 600;
                        color: #333;
                        margin-bottom: 0.4rem;
                        font-size: 0.95rem;
                    }

                    .login-footer-links {
                        display: flex;
                        gap: 10px;
                        margin-top: 16px;
                    }

                    .login-footer-links .btn {
                        flex: 1;
                    }
                </style>
            </div>
            <div class="card-body">
                <h3 class="login-box-msg text-center">Connexion</h3>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                                required autofocus autocomplete="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input id="password" class="form-control" type="password" name="password" required
                                autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Se souvenir
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="login-footer-links">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        Retour à l'accueil
                    </a>
                    <a href="{{ route('inscription') }}" class="btn btn-outline-primary">
                        Créer un compte
                    </a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-guest-layout>