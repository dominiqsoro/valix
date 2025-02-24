{{-- Exemple : resources/views/transports-list.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes engins - Valix')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <!-- En-tête avec filtre et bouton d'ajout -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Liste des Moyens de Transport</h4>
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
                <!-- Bouton Ajouter moyen -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addTransportModal">
                    <i class="mdi mdi-plus"></i> Ajouter moyen
                </button>
            </div>
        </div>

        <!-- Tableau des Moyens de Transport -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_transport">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th style="width: 16px;">
                                            <div class="form-check mb-0 ms-n1">
                                                <input type="checkbox" class="form-check-input" name="select-all"
                                                    id="select-all-transport">
                                            </div>
                                        </th>
                                        <th class="ps-0">Moyen</th>
                                        <th>Type</th>
                                        <th>Assigné à</th>
                                        <th>Propriétaire</th>
                                        <th>Couleur</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transports as $transport)
                                        <tr>
                                            <td style="width: 16px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="check"
                                                        id="customCheck1_transport">
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <img src="{{ asset('assets/images/small/moto.png') }}" alt="Moyen"
                                                    class="thumb-md me-2 rounded avatar-border">
                                                <span class="font-13 fw-medium">{{ $transport->details }}</span>
                                            </td>
                                            <td>{{ $transport->transport_type }}</td>
                                            <td>
                                                @if ($transport)
                                                    {{ $transport->driver_id }}
                                                @else
                                                    Aucun livreur
                                                @endif
                                            </td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>
                                                <span class="me-2">{{ $transport->color }}</span>
                                                <span
                                                    style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color:{{ $transport->color }};"></span>
                                            </td>
                                            </td>
                                            <td>
                                                @switch($transport->statut)
                                                    @case('disponible')
                                                        <span
                                                            class="badge bg-success-subtle text-success fw-semibold fs-13">Disponible</span>
                                                    @break

                                                    @case('en_utilisation')
                                                        <span class="badge bg-primary-subtle text-primary fw-semibold fs-13">En
                                                            utilisation</span>
                                                    @break

                                                    @case('maintenance')
                                                        <span
                                                            class="badge bg-warning-subtle text-warning fw-semibold fs-13">Maintenance</span>
                                                    @break

                                                    @case('hors_service')
                                                        <span class="badge bg-danger-subtle text-danger fw-semibold fs-13">Hors
                                                            service</span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="badge bg-secondary-subtle text-secondary fw-semibold fs-13">Inconnu</span>
                                                @endswitch
                                            </td>

                                            <td class="text-end">
                                                <form action="{{ route('transports.destroy', $transport->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm bg-danger-subtle" type="submit"
                                                        onclick="return confirm('Voulez-vous supprimer ce transport ?')">
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
                                <!-- Lien vers la page précédente -->
                                <li class="page-item {{ $transports->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $transports->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>

                                <!-- Pages numérotées -->
                                @foreach ($transports->getUrlRange(1, $transports->lastPage()) as $page => $url)
                                    <li class="page-item {{ $transports->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Lien vers la page suivante -->
                                <li class="page-item {{ $transports->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $transports->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal pour Créer un Moyen de Transport -->
        <div class="modal fade" id="addTransportModal" tabindex="-1" aria-labelledby="addTransportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransportModalLabel">Créer un Moyen de Transport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('transports.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">Nom du Moyen</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-12">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" name="type" required>
                                        <option value="velo">Velo</option>
                                        <option value="moto">Moto</option>
                                        <option value="voiture">Voiture</option>
                                        <option value="camion">Camion</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="color" class="form-label">Couleur</label>
                                    <input type="color" class="form-control" name="color" required>
                                </div>
                                <div class="col-12">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select" name="status" required>
                                        <option value="disponible">disponible</option>
                                        <option value="en_utilisation">En Utilisation</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="hors_service">Hors service</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="driver_id" class="form-label">Livreur (optionnel)</label>
                                    <select class="form-select" name="driver_id">
                                        <option value="">Aucun</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Champ caché pour l'ID de la société -->
                                <input type="hidden" name="delivery_company_id" value="{{ $user->company->id ?? '' }}">

                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fin du Modal -->

    </div> <!-- container-fluid -->


@endsection
