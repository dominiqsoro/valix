{{-- Exemple : resources/views/pages/zones-list.blade.php --}}
@extends('layouts.app')

@section('title', 'Zone de livraison - Valix')

@section('content')
    <div class="container-fluid">
        <!-- En-tête avec filtre et bouton d'ajout -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Liste des Zones de Livraison</h4>
            </div>
            <div class="text-end d-flex align-items-center">
                <!-- (Optionnel) Vous pouvez ajouter ici un dropdown pour filtrer si nécessaire -->
                <!-- Bouton Ajouter zone -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addZoneModal">
                    <i class="mdi mdi-plus"></i> Ajouter zone
                </button>
            </div>
        </div>

        <!-- Tableau des Zones de Livraison -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_zones">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th style="width: 16px;">
                                            <div class="form-check mb-0 ms-n1">
                                                <input type="checkbox" class="form-check-input" name="select-all"
                                                    id="select-all-zones">
                                            </div>
                                        </th>
                                        <th class="ps-0">Zone de Livraison</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($zones as $zone)
                                    <tr>
                                        <td style="width: 16px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="check">
                                            </div>
                                        </td>
                                        <td class="ps-0">{{ $zone->zone_name }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('zones.destroy', $zone->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-danger-subtle" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?');">
                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer">
                        @if ($zones->hasPages())
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">
                                    <!-- Bouton Précédent -->
                                    <li class="page-item {{ $zones->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $zones->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>

                                    <!-- Liens des pages -->
                                    @foreach ($zones->getUrlRange(1, $zones->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $zones->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Bouton Suivant -->
                                    <li class="page-item {{ $zones->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $zones->nextPageUrl() }}">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour Créer une Zone de Livraison -->
        <div class="modal fade" id="addZoneModal" tabindex="-1" aria-labelledby="addZoneModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addZoneModalLabel">Ajouter une Zone de Livraison</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('zones.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="zoneName" class="form-label">Zone de Livraison</label>
                                    <input type="text" class="form-control" id="zoneName" name="name" placeholder="Ex: Abobo - Banco" required>
                                </div>
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
