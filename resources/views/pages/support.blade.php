@extends('layouts.app')

@section('title', 'Service Client - Valix')

@section('content')

    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Besoin d'aide ?</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Support client</li>
                </ol>
            </div>
        </div>

        <!-- Zone de Chat -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <!-- Header de la carte -->
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="card-title mb-0">Support Chat</h5>
                    </div>
                    <!-- Corps du chat (zone scrollable) -->
                    <div class="card-body" style="height: 350px; overflow-y: auto">
                        @foreach ($messages as $message)
                            <div class="d-flex mb-3 {{ $message['sender'] == 'client' ? '' : 'flex-row-reverse text-end' }}">
                                <img src="{{ $message['sender'] == 'client' ? asset('assets/images/users/default-user.png') : asset('assets/images/users/support.jpeg') }}"
                                     alt="{{ ucfirst($message['sender']) }}" class="rounded-circle {{ $message['sender'] == 'client' ? 'me-2' : 'ms-2' }} "
                                     width="40" height="40" />
                                <div>
                                    <p class="mb-0 {{ $message['sender'] == 'client' ? 'bg-primary bg-opacity-25 text-black' : 'bg-primary text-white' }} p-2 rounded">
                                        {{ $message['message'] }}
                                    </p>
                                    <small class="text-muted">{{ $message['time'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Footer du chat avec formulaire d'envoi -->
                    <div class="card-footer bg-light">
                        <form action="{{ route('support.sendMessage') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="text" name="message" class="form-control me-2" placeholder="Votre message..." id="chatInput" required />
                            <button type="submit" class="btn btn-primary">
                                Envoyer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
