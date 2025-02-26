{{-- Exemple : resources/views/parcels-list.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes Colis - Valix')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Liste des colis</h4>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-black mb-0">Liste colis</h5>
                            <div class="ms-auto d-flex align-items-center">
                                <!-- Dropdown Filtrer par Client -->
                                <div class="dropdown me-2">
                                    <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Client <i class="mdi mdi-chevron-down ms-1 fs-14"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" id="clientFilterMenu">
                                        <a class="dropdown-item" href="#" onclick="filterByClient('all')">Tous les
                                            clients</a>
                                        @if (isset($companyClients) && $companyClients->count() > 0)
                                            @foreach ($companyClients as $client)
                                                <a class="dropdown-item" href="#"
                                                    onclick="filterByClient('{{ $client->id }}')">{{ $client->name }}</a>
                                            @endforeach
                                        @else
                                            <a class="dropdown-item text-muted">Aucun client disponible</a>
                                        @endif

                                    </div>
                                </div>

                                <script>
                                    function filterByClient(clientId) {
                                        let rows = document.querySelectorAll(".table-stock tbody tr");
                                        let totalColis = 0;
                                        let totalLivraison = 0;

                                        rows.forEach(row => {
                                            let rowClientId = row.getAttribute("data-client-id");
                                            let colisMontant = parseFloat(row.querySelector(".colis-montant").textContent.replace(/[^0-9.-]/g,
                                                '')) || 0;
                                            let livraisonMontant = parseFloat(row.querySelector(".livraison-montant").textContent.replace(
                                                /[^0-9.-]/g, '')) || 0;

                                            if (clientId === 'all' || rowClientId === clientId) {
                                                row.style.display = "";
                                                totalColis += colisMontant;
                                                totalLivraison += livraisonMontant;
                                            } else {
                                                row.style.display = "none";
                                            }
                                        });

                                        document.getElementById("total-colis").textContent = totalColis.toLocaleString() + "F";
                                        document.getElementById("total-livraison").textContent = totalLivraison.toLocaleString() + "F";
                                    }

                                    // Calcul initial pour afficher le total des colis du jour
                                    filterByClient('all');
                                </script>


                                <!-- Bouton pour ouvrir le modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addColisModal">
                                    <i class="mdi mdi-plus"></i> Ajouter colis
                                </button>

                                <!-- Modal Ajout Colis -->
                                <div class="modal " id="addColisModal" tabindex="-1" aria-labelledby="addColisModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-s">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addColisModalLabel">Ajouter un Colis</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addColisForm" action="{{ route('parcels.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <!-- Client avec recherche -->
                                                        <div class="col-12 position-relative">
                                                            <label for="clientInput" class="form-label">Client</label>
                                                            <input type="text" class="form-control" id="clientInput"
                                                                name="client" placeholder="Tapez un nom..."
                                                                onkeyup="filterClients()">
                                                            <ul class="list-group position-absolute w-100 d-none shadow"
                                                                id="clientList"
                                                                style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                                            </ul>
                                                        </div>

                                                        <!-- Zone de livraison avec recherche -->
                                                        <div class="col-12 position-relative">
                                                            <label for="zoneLivraisonInput" class="form-label">Zone de
                                                                Livraison</label>
                                                            <input type="text" class="form-control"
                                                                id="zoneLivraisonInput" name="zone"
                                                                placeholder="Tapez une zone..." onkeyup="filterZones()">
                                                            <ul class="list-group position-absolute w-100 d-none shadow"
                                                                id="zoneList"
                                                                style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                                            </ul>
                                                        </div>

                                                        <div class="row pt-2">
                                                            <!-- Montant livraison -->
                                                            <div class="col-6 position-relative">
                                                                <label for="montantLivraison" class="form-label">Montant
                                                                    Livraison (F CFA)</label>
                                                                <input type="number" class="form-control" id="montantLivraison"
                                                                    name="delivery_amount" placeholder="Ex: 1500">
                                                            </div>

                                                            <!-- Montant colis -->
                                                            <div class="col-6 position-relative">
                                                                <label for="montantColis" class="form-label">Montant Colis (F
                                                                    CFA)</label>
                                                                <input type="number" class="form-control" id="montantColis"
                                                                    name="parcel_amount" placeholder="Ex: 15000">
                                                            </div>
                                                        </div>

                                                        <!-- Statut -->
                                                        <div class="col-12">
                                                            <label for="statusSelect" class="form-label">Statut</label>
                                                            <select class="form-select" id="statusSelect" name="status">
                                                                <option selected>Choisir un statut...</option>
                                                                <option value="En cours">En cours</option>
                                                                <option value="En attente">En attente</option>
                                                                <option value="Livrée">Livrée</option>
                                                                <option value="Retournée">Retournée</option>
                                                            </select>
                                                        </div>


                                                        <!-- Note / Description du colis -->
                                                        <div class="col-12">
                                                            <label for="packageDescription" class="form-label">Note /
                                                                Description du colis</label>
                                                            <textarea class="form-control" id="packageDescription" name="package_description"
                                                                placeholder="Ajoutez une note si nécessaire"></textarea>
                                                        </div>
                                                        <!-- Boutons -->
                                                        <div class="col-12 text-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Fermer</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        fetchClientsAndZones();
                                                    });

                                                    function fetchClientsAndZones() {
                                                        fetch("/get-clients-zones") // Cette route doit renvoyer un JSON avec "clients" et "zones"
                                                            .then(response => response.json())
                                                            .then(data => {
                                                                // On attend ici que data.clients soit un tableau de noms de clients
                                                                // et data.zones un tableau de noms de zones de livraison
                                                                window.clients = data.clients;
                                                                window.zones = data.zones;
                                                            })
                                                            .catch(error => console.error("Erreur lors de la récupération des clients et zones:", error));
                                                    }

                                                    function filterList(inputId, listId, data) {
                                                        let input = document.getElementById(inputId);
                                                        let filter = input.value.toLowerCase();
                                                        let list = document.getElementById(listId);

                                                        list.innerHTML = "";
                                                        list.classList.add("d-none");

                                                        if (filter.length > 0) {
                                                            let filtered = data.filter(item => item.toLowerCase().includes(filter));
                                                            filtered.forEach(item => {
                                                                let li = document.createElement("li");
                                                                li.classList.add("list-group-item", "list-group-item-action");
                                                                li.textContent = item;
                                                                li.onclick = () => {
                                                                    input.value = item;
                                                                    list.innerHTML = "";
                                                                    list.classList.add("d-none");
                                                                };
                                                                list.appendChild(li);
                                                            });
                                                            if (filtered.length > 0) {
                                                                list.classList.remove("d-none");
                                                            }
                                                        }
                                                    }

                                                    function filterClients() {
                                                        filterList("clientInput", "clientList", window.clients || []);
                                                    }

                                                    function filterZones() {
                                                        filterList("zoneLivraisonInput", "zoneList", window.zones || []);
                                                    }
                                                </script>



                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal d'édition du statut -->
                                <div class="modal" id="editStatusModal" tabindex="-1"
                                    aria-labelledby="editStatusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStatusModalLabel">Éditer le statut du
                                                    colis</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update.parcel.status') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="statusSelect" class="form-label">Statut</label>
                                                        <select class="form-select" id="statusSelect" name="status">
                                                            <option value="pending">En cours</option>
                                                            <option value="in_transit">En attente</option>
                                                            <option value="delivered">Livrée</option>
                                                            <option value="canceled">Retournée</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="parcelId" name="parcel_id">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Écouteur d'événements pour ouvrir le modal d'édition
                                        $('#editStatusModal').on('show.bs.modal', function(event) {
                                            var button = $(event.relatedTarget); // Le bouton ayant ouvert le modal
                                            var parcelId = button.data('id'); // Récupérer l'ID du colis
                                            var currentStatus = button.data('status'); // Récupérer le statut actuel du colis

                                            // Remplir le champ hidden avec l'ID du colis
                                            $('#parcelId').val(parcelId);

                                            // Pré-sélectionner le statut actuel dans le select
                                            $('#statusSelect').val(currentStatus);
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stock mb-0">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th>Clients</th>
                                        <th>Zone de livraison</th>
                                        <th>Colis ID</th>
                                        <th>Livraison</th>
                                        <th>Colis</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($parcels as $parcel)
                                        <tr data-client-id="{{ $parcel->client_id }}">
                                            <td>{{ $parcel->client->name ?? 'N/A' }}</td>
                                            <td>{{ $parcel->deliveryZone->zone_name ?? 'N/A' }}</td>
                                            <td class="text-muted">{{ $parcel->identifiant }}</td>
                                            <td class="text-muted livraison-montant">
                                                {{ number_format($parcel->delivery_fee, 0, ',', ' ') }}F
                                            </td>
                                            <td class="text-muted colis-montant">
                                                {{ number_format($parcel->package_price, 0, ',', ' ') }}F</td>
                                            <td>
                                                @switch($parcel->status)
                                                    @case('in_transit')
                                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-13">En
                                                            attente</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-info-subtle text-info fw-semibold fs-13">En
                                                            cours</span>
                                                    @break

                                                    @case('delivered')
                                                        <span
                                                            class="badge bg-primary-subtle text-primary fw-semibold fs-13">Livrée</span>
                                                    @break

                                                    @case('canceled')
                                                        <span
                                                            class="badge bg-danger-subtle text-danger fw-semibold fs-13">Retournée</span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="badge bg-secondary-subtle text-secondary fw-semibold fs-13">Inconnu</span>
                                                @endswitch
                                            </td>
                                            <td class="text-muted">{{ \Carbon\Carbon::parse($parcel->created_at)->locale('fr')->isoFormat('D MMMM, YYYY') }}</td>
                                            <td class="d-flex justify-content-start">
                                                <!-- Bouton pour éditer le statut -->
                                                <button type="button" class="btn btn-sm bg-primary-subtle me-2"
                                                    data-bs-toggle="modal" data-bs-target="#editStatusModal"
                                                    data-id="{{ $parcel->id }}" data-status="{{ $parcel->status }}">
                                                    <i class="mdi mdi-pencil fs-14 text-primary"></i>
                                                </button>

                                                <form action="{{ route('parcels.destroy', $parcel->id) }}" method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce colis ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-subtle"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?');"
                                                        data-bs-toggle="tooltip" title="Supprimer">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                                <!-- Pied de tableau pour afficher la somme -->
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th colspan="2" class="text-end">Total :</th>
                                        <th class="text-muted" id="total-livraison">0F</th>
                                        <th class="text-muted" id="total-colis">0F</th>
                                        <th colspan="2"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                {{-- Previous page link --}}
                                <li class="page-item {{ $parcels->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $parcels->previousPageUrl() }}" tabindex="-1">Previous</a>
                                </li>

                                {{-- Pagination links with ellipsis --}}
                                @php
                                    $currentPage = $parcels->currentPage();
                                    $lastPage = $parcels->lastPage();
                                    $maxVisiblePages = 5; // Nombre de pages visibles à la fois
                                @endphp

                                {{-- Affichage de la première page --}}
                                @if ($currentPage > 2)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $parcels->url(1) }}">1</a>
                                    </li>
                                    @if ($currentPage > 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                {{-- Pages avant et après la page actuelle --}}
                                @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $parcels->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Affichage de la dernière page --}}
                                @if ($currentPage < $lastPage - 2)
                                    @if ($currentPage < $lastPage - 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $parcels->url($lastPage) }}">{{ $lastPage }}</a>
                                    </li>
                                @endif

                                {{-- Next page link --}}
                                <li class="page-item {{ $parcels->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $parcels->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>


                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchClients();
            addEventListeners();
        });

        function fetchClients() {
            fetch("/get-company-clients") // Endpoint pour récupérer les clients de la compagnie
                .then(response => response.json())
                .then(data => {
                    window.clients = data.clients;
                    populateClientFilter(window.clients);
                })
                .catch(error => console.error("Erreur lors de la récupération des clients:", error));
        }

        function populateClientFilter(clients) {
            let clientDropdown = document.getElementById("clientFilter");
            clientDropdown.innerHTML = '<a class="dropdown-item" href="#" data-client="all">Tous les clients</a>';

            clients.forEach(client => {
                let clientItem = document.createElement("a");
                clientItem.classList.add("dropdown-item");
                clientItem.href = "#";
                clientItem.textContent = client.name;
                clientItem.setAttribute("data-client", client.id);
                clientItem.addEventListener("click", function() {
                    applyFilters();
                });
                clientDropdown.appendChild(clientItem);
            });
        }

        function addEventListeners() {
            document.querySelectorAll(".dropdown-menu a").forEach(item => {
                item.addEventListener("click", function() {
                    let filterType = this.closest(".dropdown").querySelector("button").textContent.trim();
                    let filterValue = this.getAttribute("data-client") || this.textContent.trim();

                    if (filterType.includes("Client")) {
                        document.getElementById("selectedClient").textContent = this.textContent;
                        document.getElementById("selectedClient").setAttribute("data-selected-client",
                            filterValue);
                    } else if (filterType.includes("Statut")) {
                        document.getElementById("selectedStatus").textContent = this.textContent;
                        document.getElementById("selectedStatus").setAttribute("data-selected-status",
                            filterValue);
                    }
                    applyFilters();
                });
            });
        }

        function applyFilters() {
            let selectedClient = document.getElementById("selectedClient").getAttribute("data-selected-client") || "all";
            let selectedStatus = document.getElementById("selectedStatus").getAttribute("data-selected-status") || "all";

            fetch(`/filter-parcels?client=${selectedClient}&status=${selectedStatus}`)
                .then(response => response.json())
                .then(data => {
                    updateParcelTable(data.parcels);
                })
                .catch(error => console.error("Erreur lors du filtrage des colis:", error));
        }

        function updateParcelTable(parcels) {
            let tableBody = document.querySelector(".table-stock tbody");
            tableBody.innerHTML = "";

            parcels.forEach(parcel => {
                let row = document.createElement("tr");
                row.innerHTML = `
            <td>${parcel.client_name || 'N/A'}</td>
            <td>${parcel.delivery_zone || 'N/A'}</td>
            <td class="text-muted">${parcel.identifiant}</td>
            <td class="text-muted">${parcel.delivery_fee.toLocaleString()}F</td>
            <td class="text-muted">${parcel.package_price.toLocaleString()}F</td>
            <td><span class="badge ${getStatusBadge(parcel.status)}">${parcel.status_label}</span></td>
            <td class="text-muted">${parcel.date}</td>
            <td><button class="btn btn-sm bg-danger-subtle" onclick="deleteParcel(${parcel.id})"><i class="mdi mdi-delete fs-14 text-danger"></i></button></td>
        `;
                tableBody.appendChild(row);
            });
        }

        function getStatusBadge(status) {
            switch (status) {
                case 'pending':
                    return "bg-warning-subtle text-warning";
                case 'in_transit':
                    return "bg-info-subtle text-info";
                case 'delivered':
                    return "bg-primary-subtle text-primary";
                case 'canceled':
                    return "bg-danger-subtle text-danger";
                default:
                    return "bg-secondary-subtle text-secondary";
            }
        }
    </script>

@endsection
