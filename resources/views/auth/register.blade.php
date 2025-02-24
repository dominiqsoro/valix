{{-- Exemple : resources/views/auth/register.blade.php --}}
@extends('layouts.layout')

@section('title', "S'inscrire - Valix")

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
                                <p class="text-dark text-capitalize fs-14 mb-0">S'inscrire à Valix.</p>
                            </div>

                            <div class="pt-0">
                                <form action="{{ route('register') }}" method="POST" class="my-4">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="fullname" class="form-label">Nom complet</label>
                                        <input class="form-control" type="text" id="fullname" name="full_name" required
                                            placeholder="Entrez votre nom complet">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="emailaddress" class="form-label">Adresse e-mail</label>
                                        <input class="form-control" type="email" id="emailaddress" name="email" required
                                            placeholder="Entrez votre adresse e-mail">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input class="form-control" type="text" id="phone" name="phone" required
                                            placeholder="Entrez votre numéro de téléphone">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="structure" class="form-label">Nom de votre structure</label>
                                        <input class="form-control" type="text" id="structure" name="structure_name"
                                            required placeholder="Entrez le nom de votre structure">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Créer un mot de passe</label>
                                        <input class="form-control" type="password" id="password" name="password" required
                                            placeholder="Confirmez votre mot de passe">
                                    </div>

                                    <div class="form-group d-flex mb-3">
                                        <div class="col-sm-12">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signup"
                                                    name="terms" required>
                                                <label class="form-check-label" for="checkbox-signup">J'accepte les
                                                    conditions d'utilisation</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="submit">S'inscrire</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="text-center text-muted mb-4">
                                    <p class="mb-0">Vous avez déjà un compte ? <a class="text-primary ms-2 fw-medium"
                                            href="{{ route('login') }}">Se
                                            connecter</a></p>
                                </div>
                            </div>

                            <!-- Script pour la vérification dynamique du mot de passe -->
                            <script>
                                document.getElementById("password").addEventListener("input", function() {
                                    var password = this.value;
                                    // Vérification des critères
                                    var minLength = password.length >= 8;
                                    var hasUpper = /[A-Z]/.test(password);
                                    var hasNumber = /[0-9]/.test(password);
                                    var hasSpecial = /[^A-Za-z0-9]/.test(password);

                                    document.getElementById("req-length").className = minLength ? "text-primary" : "text-danger";
                                    document.getElementById("req-uppercase").className = hasUpper ? "text-primary" : "text-danger";
                                    document.getElementById("req-number").className = hasNumber ? "text-primary" : "text-danger";
                                    document.getElementById("req-special").className = hasSpecial ? "text-primary" : "text-danger";
                                });
                            </script>



                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
