{{-- Exemple : resources/views/users-clients.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes clients - Valix')

@section('content')

    <div class="container-fluid">
        <!-- Header avec filtre et bouton d'ajout -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Liste des Clients</h4>
            </div>
            <div class="text-end d-flex align-items-center">
                <!-- Dropdown pour filtrer par statut -->
                <div class="dropdown me-2">
                    <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filtrer par statut <i class="mdi mdi-chevron-down ms-1 fs-14"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Tous</a>
                        <a class="dropdown-item" href="#">Actif</a>
                        <a class="dropdown-item" href="#">Inactif</a>
                    </div>
                </div>

                <!-- Bouton Ajouter client qui ouvre le modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addClientModal">
                    <i class="mdi mdi-plus"></i> Ajouter client
                </button>
            </div>
        </div>

        <!-- Tableau des clients -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_clients">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th style="width: 16px;">
                                            <div class="form-check mb-0 ms-n1">
                                                <input type="checkbox" class="form-check-input" name="select-all"
                                                    id="select-all-clients">
                                            </div>
                                        </th>
                                        <th class="ps-0">Client</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Manager</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td style="width: 16px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check"
                                                        id="customCheck1_client_{{ $client->id }}">
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <span class="font-13 fw-medium">{{ $client->name }}</span>
                                            </td>
                                            <td>{{ $client->user->email ?? 'N/A' }}</td>
                                            <td>{{ $client->user->phone ?? 'N/A' }}</td>
                                            <td>{{ $company->user->full_name ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-success-subtle text-success fw-semibold fs-13">Actif</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm bg-primary-subtle me-1"
                                                    data-bs-toggle="tooltip" title="Modifier">
                                                    <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                </a>
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-subtle"
                                                        data-bs-toggle="tooltip" title="Supprimer">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                <!-- Pagination personnalisée pour les clients -->
                                @if ($clients->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $clients->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $clients->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($clients->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $clients->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour Créer un Compte Client -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Modal -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">Créer un Compte Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form id="clientForm" method="POST" action="{{ route('clients.store') }}">
                            @csrf
                            <!-- Champ caché pour l'ID de la compagnie -->
                            <input type="hidden" name="company_id" value="{{ $company->company_id }}">

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nom du client</label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                    placeholder="Nom complet" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="Numéro de téléphone" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Localisation</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    placeholder="Lieu d'habitation" required>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin du Modal -->
    </div> <!-- container-fluid -->


@endsection
