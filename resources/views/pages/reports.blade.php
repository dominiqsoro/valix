{{-- Exemple : resources/views/reports.blade.php --}}
@extends('layouts.app')

@section('title', 'Rapports - Valix')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- En-tête avec bouton de filtre -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Rapports des Colis</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="text-end d-flex align-items-center">
                <!-- Bouton pour ouvrir le modal de filtre -->
                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal"
                    data-bs-target="#filterParcelModal">
                    <i class="mdi mdi-filter"></i> Filtrer & PDF
                </button>
            </div>
        </div>

        <!-- Tableau des colis -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-parcels" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>ID colis</th>
                                        <th>Zone de livraison</th>
                                        <th>Client</th>
                                        <th>Montant colis</th>
                                        <th>Montant livraison</th>
                                        <th>Statut</th>
                                        <th>Date de livraison</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
                                    @foreach ($parcels as $parcel)
                                        <tr>
                                            <td>{{ $parcel->identifiant }}</td>
                                            <td>{{ $parcel->deliveryZone->zone_name ?? 'N/A' }}</td>
                                            <td>{{ $parcel->client->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($parcel->package_price, 0, ',', ' ') }}F</td>
                                            <td>{{ number_format($parcel->delivery_fee, 0, ',', ' ') }}F</td>
                                            <td>
                                                @switch($parcel->status)
                                                    @case('in_transit')
                                                        <span class="badge bg-warning">En attente</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-info">En cours</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class="badge bg-primary">Livrée</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge bg-danger">Retournée</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary">Inconnu</span>
                                                @endswitch
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($parcel->created_at)->locale('fr')->isoFormat('D MMMM, YYYY') }}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Ajoutez d'autres lignes de colis ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                <!-- Previous button -->
                                <li class="page-item {{ $parcels->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $parcels->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>

                                <!-- Page numbers -->
                                @foreach ($parcels->getUrlRange(1, $parcels->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $parcels->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next button -->
                                <li class="page-item {{ $parcels->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $parcels->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour Filtrer et Exporter en PDF -->
        <div class="modal fade" id="filterParcelModal" tabindex="-1" aria-labelledby="filterParcelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterParcelModalLabel">Filtrer les Colis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('reports.pdf') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <!-- Filtrer par Date de livraison -->
                                <div class="col-12">
                                    <label class="form-label">Date de livraison</label>
                                    <input type="text" class="form-control" id="minmax-datepicker" name="delivery_date"
                                        placeholder="YYYY-MM-DD">
                                </div>
                                <!-- Filtrer par Client -->
                                <div class="col-12">
                                    <label for="filterClient" class="form-label">Client</label>
                                    <select class="form-select" id="filterClient" name="client">
                                        <option value="Tous les clients" selected>Tous les clients</option>
                                        @foreach ($companyClients as $client)
                                            <option value="{{ $client->name }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Filtrer par Statut -->
                                <div class="col-12">
                                    <label for="filterStatus" class="form-label">Statut</label>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="Tous les statuts" selected>Tous les statuts</option>
                                        <option value="En attente">En attente</option>
                                        <option value="En cours">En cours</option>
                                        <option value="Livrée">Livrée</option>
                                        <option value="Retournée">Retournée</option>
                                    </select>
                                </div>
                                <!-- Boutons pour valider le filtre et imprimer ou télécharger en PDF -->
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Valider & Imprimer PDF</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container-fluid -->



@endsection

