{{-- Exemple : resources/views/users-drivers.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes livreurs - Valix')

@section('content')

    <div class="container-fluid">
        <!-- Header avec filtre et bouton d'ajout -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Liste des Livreurs</h4>
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
                <!-- Bouton Ajouter livreur -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addDriverModal">
                    <i class="mdi mdi-plus"></i> Ajouter livreur
                </button>
            </div>
        </div>

        <!-- Tableau des Livreurs -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_drivers">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th style="width: 16px;">
                                            <div class="form-check mb-0 ms-n1">
                                                <input type="checkbox" class="form-check-input" name="select-all"
                                                    id="select-all-drivers">
                                            </div>
                                        </th>
                                        <th class="ps-0">Livreur</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Transport</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <td style="width: 16px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check"
                                                        id="customCheck1_driver_{{ $driver->id }}">
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <span
                                                    class="font-13 fw-medium">{{ $driver->user->full_name ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $driver->user->email ?? 'N/A' }}</td>
                                            <td>{{ $driver->user->phone ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span>{{ $driver->transport->details ?? 'Aucun transport assigné' }}</span>
                                                    <span class="ms-2"
                                                        style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color: {{ $driver->transport->color ?? '#fff' }};"></span>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge bg-primary-subtle text-primary fw-semibold fs-13">
                                                    {{ $driver->status ?? 'Actif' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a aria-label="modifier" class="btn btn-sm bg-primary-subtle me-1"
                                                    data-bs-toggle="tooltip" title="Modifier">
                                                    <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                </a>
                                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" title="Supprimer">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- Ajoutez d'autres lignes de livreurs ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                <!-- Pagination personnalisée pour les livreurs -->
                                @if ($drivers->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $drivers->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                @foreach ($drivers->getUrlRange(1, $drivers->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $drivers->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($drivers->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $drivers->nextPageUrl() }}">Next</a>
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

        <!-- Modal pour Créer un Compte Livreur -->
        <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDriverModalLabel">Créer un Compte Livreur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('drivers.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="company_id" value="{{ $company->company_id }}">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="driverName" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" id="driverName" name="name"
                                        placeholder="Entrez le nom complet" required>
                                </div>
                                <div class="col-12">
                                    <label for="driverPhone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="driverPhone" name="phone"
                                        placeholder="Entrez votre téléphone " required>
                                </div>
                                <div class="col-12">
                                    <label for="driverMEngin" class="form-label">Moto</label>
                                    <select class="form-select" id="driverEng" name="moto">
                                        <option selected>Choisir un engin...</option>
                                        @foreach ($transports as $transport)
                                            <option value="{{ $transport->id }}">{{ $transport->details }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="form-label">Localisation</label>
                                    <input type="text" name="location" id="driverLocation" class="form-control"
                                        placeholder="Lieu d'habitation" required>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                        +
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin du Modal -->
    </div> <!-- container-fluid -->


@endsection
