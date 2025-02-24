{{-- Exemple : resources/views/auth/logout.blade.php --}}
@extends('layouts.layout')

@section('title', 'Se déconnecter - Valix')

@section('content')

    <!-- Section principale -->
    <div class="col-xl-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card p-3 mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="{{ route('dashboard') }}" class="auth-logo">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" class="mx-auto"
                                    height="28">
                            </a>
                        </div>

                        <div class="text-center auth-title-section mt-4">
                            <h3 class="text-dark fs-20 fw-medium mb-2">Vous êtes déconnecté</h3>
                            <p class="text-muted fs-15">Merci d'utiliser Valix</p>
                        </div>

                        <div class="text-center">
                            <a class="btn btn-primary mt-3" href="{{ route('login') }}">Se connecter</a>
                        </div>

                        <div class="maintenance-img text-center pt-4">
                            <img src="{{ asset('assets/images/svg/logout.svg') }}" height="200" alt="Déconnexion">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
