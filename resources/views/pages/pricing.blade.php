{{-- Exemple : resources/views/pricing.blade.php --}}
@extends('layouts.app')

@section('title', 'Mon abonnement - Valix')

@section('content')


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-lg-12">
                <div class="card d-block shadow-sm">
                    <h5 class="card-header bg-primary text-white mt-2 rounded-2">
                        Votre Abonnement Actuel
                    </h5>
                    <div class="card-body">
                        @if ($userSubscription)
                            <h5 class="card-title">
                                Abonnement : <span id="planName">{{ $userSubscription->subscription->name }}</span>
                            </h5>
                            <p class="card-text text-muted">
                                Vous profitez actuellement du plan
                                <strong id="planLevel">{{ $userSubscription->subscription->name }}</strong>, offrant un
                                accès complet à toutes nos fonctionnalités essentielles.
                                Assurez la continuité de vos avantages exclusifs en
                                renouvelant avant l'expiration.
                            </p>
                            <p class="card-text">
                                <strong>Date d'expiration :</strong>
                                <span
                                    id="expiryDate">{{ \Carbon\Carbon::parse($userSubscription->end_date)->format('d F Y') }}</span>
                            </p>
                            <a href="#" class="btn btn-outline-primary btn-lg mt-1">Renouveler Maintenant</a>
                        @else
                            <p>Vous n'avez pas d'abonnement actif.</p>
                        @endif

                        <p class="text-center text-danger mt-2">
                            Ne laissez pas votre accès expirer ! Renouvelez dès
                            maintenant et continuez à bénéficier de nos services
                            premium sans interruption.
                        </p>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            <!-- Titre de la section -->
            <div class="col-lg-12 text-center">
                <br />
                <h3 class="mb-2">Forfaits Valix</h3>
                <p class="text-muted mb-5">
                    Choisissez le forfait qui correspond le mieux à votre activité
                    et évoluez selon vos besoins.
                </p>
            </div>

            @foreach ($subscriptions as $subscription)
                <div class="pricing-box col-xl-3 col-md-6 mb-4">
                    <div
                        class="card card-h-full {{ $subscription->name == 'Essentiel' ? 'border-primary border' : '' }} shadow-none">
                        <div class="inner-box card-body p-4">
                            <!-- Choix de l'icône et du style en fonction de l'abonnement -->
                            @switch($subscription->name)
                                @case('Starter')
                                    <div
                                        class="bg-warning bg-opacity-10 text-warning rounded-3 px-2 py-1 d-inline-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-rocket fs-19"></i>
                                    </div>
                                @break

                                @case('Essentiel')
                                    <div
                                        class="bg-primary bg-opacity-10 text-primary rounded-3 px-2 py-1 d-inline-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-account-star fs-19"></i>
                                    </div>
                                @break

                                @case('Pro')
                                    <div
                                        class="bg-info bg-opacity-10 text-info rounded-3 px-2 py-1 d-inline-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-office-building fs-19"></i>
                                    </div>
                                @break

                                @case('Premium')
                                    <div
                                        class="bg-warning bg-opacity-10 text-warning rounded-3 px-2 py-1 d-inline-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-rocket fs-19"></i>
                                    </div>
                                @break
                            @endswitch

                            <div class="flex-shrink-0 pb-3 mb-1 mt-4">
                                <h2 class="month mb-0">
                                    <sup class="fw-semibold"><small>FCFA</small></sup>
                                    <span
                                        class="fw-semibold fs-28">{{ number_format($subscription->price, 0, ',', ' ') }}</span>/
                                    <span class="fs-14 text-muted">mois</span>
                                </h2>
                            </div>
                            <div class="plan-header">
                                <h5
                                    class="plan-title {{ $subscription->name == 'Essentiel' ? 'text-primary' : 'text-warning' }}">
                                    {{ $subscription->name }}</h5>
                                <p class="plan-subtitle">{{ $subscription->details }}</p>
                            </div>
                            <ul class="flex-grow-1 plan-stats list-unstyled">
                                <li><i data-feather="check" class="check-icon text-primary me-2"></i>Gestion jusqu'à
                                    {{ $subscription->name == 'Starter' ? '200' : ($subscription->name == 'Essentiel' ? '500' : 'illimitée') }}
                                    colis</li>
                                <li><i data-feather="check"
                                        class="check-icon text-primary me-2"></i>{{ $subscription->name == 'Premium' ? 'Support VIP 24/7' : ($subscription->name == 'Essentiel' ? 'Support prioritaire' : 'Support de base') }}
                                </li>
                                <li><i data-feather="x" class="check-icon text-danger me-2"></i>Tracking colis :
                                    {{ $subscription->name == 'Premium' ? 'disponible' : 'non' }}</li>
                            </ul>
                            <div class="flex-shrink-0 text-center">
                                <button type="button"
                                    class="btn {{ $subscription->name == 'Essentiel' ? 'btn-primary' : 'btn-outline-primary' }} w-100 rounded-2 fw-medium"
                                    data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    Choisir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach




        </div>
    </div>


    <!-- Modal de Paiement -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        Effectuer le paiement de votre abonnement
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm" action="javascript:void(0);">
                        <!-- Sélection du moyen de paiement -->
                        <div class="mb-3">
                            <label class="form-label">Sélectionnez votre moyen de paiement</label>
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <!-- Orange Money -->
                                <div class="card payment-option orange-money" onclick="selectPayment('orange')">
                                    <span>Orange Money</span>
                                    <input type="radio" name="paymentMethod" value="orange" class="d-none" />
                                </div>
                                <!-- MTN Money -->
                                <div class="card payment-option mtn-money" onclick="selectPayment('mtn')">
                                    <span>MTN Money</span>
                                    <input type="radio" name="paymentMethod" value="mtn" class="d-none" />
                                </div>
                                <!-- Moov Money -->
                                <div class="card payment-option moov-money" onclick="selectPayment('moov')">
                                    <span>Moov Money</span>
                                    <input type="radio" name="paymentMethod" value="moov" class="d-none" />
                                </div>
                                <!-- Wave Money -->
                                <div class="card payment-option wave-money" onclick="selectPayment('wave')">
                                    <span>Wave Money</span>
                                    <input type="radio" name="paymentMethod" value="wave" class="d-none" />
                                </div>
                                <!-- Djamo -->
                                <div class="card payment-option djamo" onclick="selectPayment('djamo')">
                                    <span>Djamo</span>
                                    <input type="radio" name="paymentMethod" value="djamo" class="d-none" />
                                </div>
                                <!-- Push Money -->
                                <div class="card payment-option push-money" onclick="selectPayment('push')">
                                    <span>Push Money</span>
                                    <input type="radio" name="paymentMethod" value="push" class="d-none" />
                                </div>
                            </div>
                        </div>

                        <!-- Détails de paiement (initialement cachés) -->
                        <div id="paymentDetails" class="collapse">
                            <!-- Pour Mobile Money : champ numéro de téléphone -->
                            <div id="mobileMoneyFields" class="collapse">
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Numéro de téléphone</label>
                                    <input type="text" class="form-control" id="phoneNumber"
                                        placeholder="Entrez votre numéro de téléphone" />
                                </div>
                            </div>
                            <!-- Pour les paiements par carte (Push et Djamo) -->
                            <div id="cardPaymentFields" class="collapse">
                                <div class="mb-3">
                                    <label for="cardNumber" class="form-label">Numéro de carte</label>
                                    <input type="text" class="form-control" id="cardNumber"
                                        placeholder="Entrez le numéro de carte" />
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="cardExpiry" class="form-label">Date d'expiration</label>
                                        <input type="text" class="form-control" id="cardExpiry"
                                            placeholder="MM/YY" />
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="cardCVV" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cardCVV" placeholder="CVV" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Fermer
                            </button>
                            <button type="submit" class="btn btn-primary">Payer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles pour les cartes colorées -->
    <style>
        .payment-option {
            width: 110px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            opacity: 0.4;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            opacity: 1;
        }

        .payment-option.selected {
            border: 3px solid #31992e;
            opacity: 1;
        }

        /* Couleurs des moyens de paiement */
        .orange-money {
            background-color: #ff7a00;
        }

        .mtn-money {
            background-color: #ffcc06;
            color: black;
        }

        .moov-money {
            background-color: #eb640c;
        }

        .wave-money {
            background-color: #1e88e5;
        }

        .djamo {
            background-color: #080404;
        }

        .push-money {
            background-color: #4cab33;
        }
    </style>

    <!-- Script pour gérer la sélection -->
    <script>
        function selectPayment(method) {
            // Désélectionner toutes les cartes
            document
                .querySelectorAll(".payment-option")
                .forEach(function(card) {
                    card.classList.remove("selected");
                    card.querySelector("input[type=radio]").checked = false;
                });

            // Sélectionner la carte cliquée
            var selectedCard = document.querySelector(
                '.payment-option[onclick*="' + method + '"]'
            );
            selectedCard.classList.add("selected");
            selectedCard.querySelector("input[type=radio]").checked = true;

            // Affichage des champs en fonction du type de paiement
            if (
                method === "orange" ||
                method === "mtn" ||
                method === "moov" ||
                method === "wave"
            ) {
                document
                    .getElementById("mobileMoneyFields")
                    .classList.add("show");
                document
                    .getElementById("cardPaymentFields")
                    .classList.remove("show");
            } else {
                document
                    .getElementById("mobileMoneyFields")
                    .classList.remove("show");
                document
                    .getElementById("cardPaymentFields")
                    .classList.add("show");
            }

            // Affichage des détails de paiement
            var details = document.getElementById("paymentDetails");
            if (!details.classList.contains("show")) {
                new bootstrap.Collapse(details, {
                    toggle: true
                });
            }
        }
    </script>





@endsection
