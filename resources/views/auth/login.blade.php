{{-- Exemple : resources/views/auth/login.blade.php --}}
@extends('layouts.layout')

@section('title', 'Se connecter - Valix')

@section('content')
    <div class="col-xl-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card p-3 mb-0">
                    <div class="card-body">

                        <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                            <div class="mb-4 p-0 text-center">
                                <a class='auth-logo' href='dashboard.html'>
                                    <img src="assets/images/logo-dark.png" alt="logo-dark" class="mx-auto" height="28" />
                                </a>
                            </div>

                            <div class="auth-title-section mb-3 text-center">
                                <!-- <h3 class="text-dark fs-20 fw-medium mb-2">Soyez de le bienvenue </h3> -->
                                <p class="text-dark text-capitalize fs-14 mb-0">Se connecter à Valix.</p>
                            </div>

                            <div class="pt-0">
                                <form action="{{ route('login') }}" method="POST" class="my-4">
                                    @csrf <!-- Token CSRF pour éviter les attaques -->
                                    <div class="form-group mb-3">
                                        <label for="emailaddress" class="form-label">Adresse e-mail</label>
                                        <input class="form-control" type="email" id="emailaddress" name="email" required
                                            placeholder="Entrez votre adresse e-mail">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input class="form-control" type="password" id="password" name="password" required
                                            placeholder="Entrez votre mot de passe">
                                    </div>

                                    <div class="form-group d-flex mb-3">
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                                    name="remember" {{ Cookie::get('remember_email') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkbox-signin">Se souvenir de
                                                    moi</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            <a class="text-muted fs-14" href="passwordrecovery.html">Mot de passe oublié
                                                ?</a>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="submit">Connexion</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @if ($errors->any() || session('success'))
                                    <div class="alert {{ $errors->any() ? 'alert-danger' : 'alert-primary' }}">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            @if (session('success'))
                                                <li>{{ session('success') }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                <div class="text-center text-muted mb-4">
                                    <p class="mb-0">Vous n'avez pas de compte ? <a class="text-primary ms-2 fw-medium"
                                            href="{{ route('register') }}">Inscrivez-vous</a></p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
