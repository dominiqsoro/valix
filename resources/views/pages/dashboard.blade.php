{{-- Exemple : resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - Valix')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Tableau de bord</h4>
            </div>
        </div>

        <!-- Start Row -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-secondary-subtle rounded-2 p-1 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                    d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4" />
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Client(e)(s)</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black me-2">{{ number_format($totalClients ?? 0) }}</h3>
                                </div>
                            </div>

                            <div>
                                <p class="text-muted mb-0 fs-13">
                                    <small class="text-dark fs-14"> Nombre de clients ! </small>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-primary-subtle rounded-2 p-1 me-2 border border-dashed border-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 14 14">
                                                <path fill="#287F71" fill-rule="evenodd"
                                                    d="M13.463 9.692C13.463 12.664 10.77 14 7 14S.537 12.664.537 9.713c0-3.231 1.616-4.868 4.847-6.505L4.24 1.077A.7.7 0 0 1 4.843 0H9.41a.7.7 0 0 1 .603 1.023L8.616 3.208c3.23 1.615 4.847 3.252 4.847 6.484M7.625 4.887a.625.625 0 1 0-1.25 0v.627a1.74 1.74 0 0 0-.298 3.44l1.473.322a.625.625 0 0 1-.133 1.236h-.834a.625.625 0 0 1-.59-.416a.625.625 0 1 0-1.178.416a1.877 1.877 0 0 0 1.56 1.239v.636a.625.625 0 1 0 1.25 0v-.636a1.876 1.876 0 0 0 .192-3.696l-1.473-.322a.49.49 0 0 1 .105-.97h.968a.622.622 0 0 1 .59.416a.625.625 0 0 0 1.178-.417a1.874 1.874 0 0 0-1.56-1.238z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Livraison du jour</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black">{{ number_format($totalDeliveryAmount ?? 0, 0) }} FCFA</h3>
                                </div>
                            </div>

                            <div>
                                <p class="text-muted mb-0 fs-13">
                                    <small class="text-dark fs-14">Somme des livraisons du jour </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info-subtle rounded-2 p-1 me-2 border border-dashed border-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#73bbe2"
                                                    d="M7 20V8.975q0-.825.6-1.4T9.025 7H20q.825 0 1.413.587T22 9v8l-5 5H9q-.825 0-1.412-.587T7 20M2.025 6.25q-.15-.825.325-1.487t1.3-.813L14.5 2.025q.825-.15 1.488.325t.812 1.3L17.05 5H9Q7.35 5 6.175 6.175T5 9v9.55q-.4-.225-.687-.6t-.363-.85zM20 16h-4v4z" />
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Montant colis</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black">{{ number_format($totalParcelAmount ?? 0, 0) }} FCFA</h3>
                                </div>
                            </div>

                            <div>
                                <p class="text-muted mb-0 fs-13">
                                    <small class="text-dark fs-14"> Somme des colis du jour ! </small>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-warning-subtle rounded-2 p-1 me-2 border border-dashed border-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#f59440"
                                                    d="M5.574 4.691c-.833.692-1.052 1.862-1.491 4.203l-.75 4c-.617 3.292-.926 4.938-.026 6.022C4.207 20 5.88 20 9.23 20h5.54c3.35 0 5.025 0 5.924-1.084c.9-1.084.591-2.73-.026-6.022l-.75-4c-.439-2.34-.658-3.511-1.491-4.203C17.593 4 16.403 4 14.02 4H9.98c-2.382 0-3.572 0-4.406.691"
                                                    opacity="0.5" />
                                                <path fill="#988D4D"
                                                    d="M12 9.25a2.251 2.251 0 0 1-2.122-1.5a.75.75 0 1 0-1.414.5a3.751 3.751 0 0 0 7.073 0a.75.75 0 1 0-1.414-.5A2.251 2.251 0 0 1 12 9.25" />
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Colis du jour</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black">{{ number_format($totalParcelsToday ?? 0) }}</h3>
                                </div>

                            </div>

                            <div>
                                <p class="text-muted mb-0 fs-13">
                                    <small class="text-dark fs-14"> Nombre de colis ! </small>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Start -->

        <div class="row">
            <!-- Start Products Stock -->
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-black mb-0">Liste colis</h5>
                            <div class="ms-auto">
                                <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Statut<i class="mdi mdi-chevron-down ms-1 fs-14"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">En attente</a>
                                    <a class="dropdown-item" href="#">Livrée</a>
                                    <a class="dropdown-item" href="#">Retournée</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-stock mb-0">

                                <thead>
                                    <tr class="text-capitalize">
                                        <th>Clients</th>
                                        <th>Zone de livraison</th>
                                        <th>Colis ID</th>
                                        <th>Montant livraison</th>
                                        <th>Montant colis</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($parcels as $parcel)
                                    <tr>
                                        <td>{{ $parcel->client->name }} - {{ $parcel->client->location }}</td>
                                        <td> {{ $parcel->delivery_address }}</td>
                                        <td class="text-muted">{{ $parcel->identifiant }}</td>
                                        <td class="text-muted">{{  number_format($parcel->delivery_fee ?? 0) }} F</td>
                                        <td class="text-muted">{{  number_format($parcel->package_price ?? 0) }} F</td>
                                        <td>
                                            @if ($parcel->status == 'in_transit')
                                                <span class="badge bg-warning-subtle text-warning fw-semibold fs-13">En attente</span>
                                            @elseif ($parcel->status == 'pending')
                                                <span class="badge bg-primary-subtle text-info fw-semibold fs-13">En cours</span>
                                            @elseif ($parcel->status == 'delivered')
                                                <span class="badge bg-primary-subtle text-primary fw-semibold fs-13">Livrée</span>
                                            @elseif ($parcel->status == 'canceled')
                                                <span class="badge bg-danger-subtle text-danger fw-semibold fs-13">Retournée</span>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ \Carbon\Carbon::parse($parcel->created_at)->locale('fr')->isoFormat('D MMMM, YYYY') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Products Stock -->
        </div>

    </div>
    <!-- container-fluid -->
@endsection
