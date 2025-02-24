<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Fichier rapport | Valix - Optimisez vos livraisons, boostez votre business.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optimisez vos livraisons, boostez votre business">
    <meta name="author" content="ByDS">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style">
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Flatpickr Timepicker css -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>


    {{-- page : (resources/views/pdf/reports.blade.php) --}}
    <div>
        <div class="text-center mb-4">
            <h2>Rapports du client <b>{{ $clientFilter ?? 'Tous les clients' }}</b></h2>
            <a class="btn btn-primary-outline border-primary m-2" href="{{ route('reports') }}">Retour à la page</a>
            <button class="btn btn-primary m-2" onclick="downloadPDF()">Télécharger PDF</button>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Rapport des livraisons de
                    {{ $company->name ?? 'Société de livraison' }}</h4>
                <p class="text-center">
                    Ce tableau présente un aperçu des colis livrés, en cours ou retournés, ainsi que les montants
                    associés pour le/la client(e) <b>{{ $clientFilter ?? 'Tous les clients' }}</b>.
                </p>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
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
                            @foreach ($parcels as $parcel)
                                <tr>
                                    <td>{{ $parcel->identifiant }}</td>
                                    <td>{{ $parcel->deliveryZone->zone_name ?? 'N/A' }}</td>
                                    <td>{{ $parcel->client->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($parcel->package_price, 0, ',', ' ') }}F</td>
                                    <td>{{ number_format($parcel->delivery_fee, 0, ',', ' ') }}F</td>
                                    <td> @switch($parcel->status)
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
                                    <td>{{ \Carbon\Carbon::parse($parcel->created_at)->locale('fr')->isoFormat('D MMMM, YYYY') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td><b>Total</b></td>
                                <td class="text-muted">
                                    {{ number_format($parcels->sum('package_price'), 0, ',', ' ') }}F</td>
                                <td class="text-muted">{{ number_format($parcels->sum('delivery_fee'), 0, ',', ' ') }}F
                                </td>
                                <td></td>
                                <td>{{ \Carbon\Carbon::parse($parcel->created_at)->locale('fr')->isoFormat('D MMMM, YYYY') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
            function downloadPDF() {
                const element = document.body;
                const clientName = "{{ $clientFilter ?? 'Tous_les_clients' }}".replace(/\s+/g, '_'); // Remplace les espaces par des underscores
                const date = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
                const fileName = `rapport_livraisons_${clientName}_${date}.pdf`;

                html2pdf().from(element).save(fileName);
            }
        </script>

    </div>



    <footer>
        <div class="row text-center w-100">
            <div class="col fs-13 text-muted">
                &copy; Valix
                <script>
                    document.write(new Date().getFullYear())
                </script>
                - Made with <span class="mdi mdi-heart text-danger"></span>
                by <a href="#!" class="text-reset fw-semibold">Dominique SORO</a>
            </div>
        </div>
    </footer>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Vendor Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Apexcharts JS -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Script pour le graphique (vérifiez que le fichier est bien à cet emplacement) -->
    <script src="{{ asset('assets/libs/apexcharts/stock-prices.js') }}"></script>

    <!-- Widgets Init Js -->
    <script src="{{ asset('assets/js/pages/ecommerce-dashboard.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crm-dashboard.init.js') }}"></script>

    <!-- Flatpickr Timepicker Plugin js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-picker.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Scripts additionnels -->
    @stack('scripts')

</body>

</html>
