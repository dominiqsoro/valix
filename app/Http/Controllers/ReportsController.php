<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Client;
use App\Models\DeliveryZone;
use Carbon\Carbon;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;



class ReportsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            // Si l'utilisateur n'a pas de compagnie associée, on retourne une vue vide ou on gère l'erreur
            return view('pages.reports', [
                'parcels' => collect(),
                'clients' => collect()
            ])->with('error', 'Aucune compagnie associée à votre compte.');
        }


        $companyClients = Client::all(); // Récupère tous les clients (à adapter selon ta logique)

        // Récupérer les colis de la compagnie avec les infos associées (client et zone)
        $parcels = Parcel::with(['client', 'deliveryZone'])
            ->where('company_id', $company->company_id)
            ->paginate(8);

        // Récupérer les clients de la compagnie
        $clients = Client::where('company_id', $company->company_id)->get();

        return view('pages.reports', compact('parcels', 'clients', 'companyClients'));
    }


    public function showParcels()
    {
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $companyId = Company::where('user_id', $user->id)->first();
        $today = Carbon::today(); // Date d'aujourd'hui

        // Filtrer les colis du jour et de la compagnie de l'utilisateur
        $parcels = Parcel::whereDate('created_at', $today)
            ->where('company_id', $companyId)
            ->with('client')
            ->get();

        $companyClients = Client::where('company_id', $companyId)->get();

        return view('pages.reports', compact('parcels', 'companyClients'));
    }


    public function store(Request $request)
    {
        // Valider les champs nécessaires
        $request->validate([
            'client' => 'required|string',
            'zone' => 'required|string',
            'delivery_amount' => 'required|numeric',
            'parcel_amount' => 'required|numeric',
            'status' => 'required|string',
            'package_description' => 'nullable|string',
        ]);

        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();
        if (!$company) {
            return redirect()->route('parcels.index')->with('error', 'Aucune compagnie associée à votre compte.');
        }

        // Récupérer ou créer le client en fonction du nom fourni et de la compagnie
        $clientName = $request->input('client');
        $client = Client::where('name', $clientName)
            ->where('company_id', $company->company_id)
            ->first();
        if (!$client) {
            $client = Client::create([
                'user_id'    => $user->id,
                'company_id' => $company->company_id,
                'name'       => $clientName,
                'location'   => '', // À compléter si besoin
            ]);
        }

        // Récupérer ou créer la zone de livraison en fonction du nom fourni
        $zoneName = $request->input('zone');
        $deliveryZone = DeliveryZone::where('zone_name', $zoneName)->first();
        if (!$deliveryZone) {
            $deliveryZone = DeliveryZone::create([
                'zone_name'   => $zoneName,
                'description' => '', // À compléter si besoin
            ]);
        }

        // Conversion du statut en valeur attendue par la BDD
        $statusMapping = [
            'En cours' => 'in_transit',
            'En attente' => 'pending',
            'Livrée'     => 'delivered',
            'Retournée'  => 'canceled',
        ];

        $status = $statusMapping[$request->input('status')] ?? 'pending';
        // Générer un identifiant unique pour le colis (8 caractères maximum)
        $identifiant = strtoupper(substr(uniqid(), 0, 8));

        // Créer le colis avec la compagnie du manager connecté
        $parcel = Parcel::create([
            'company_id'          => $company->company_id,
            'identifiant'         => $identifiant,
            'client_id'           => $client->id,
            'zone_id'             => $deliveryZone->id,
            'delivery_address'    => $deliveryZone->zone_name, // Ici, le nom de la zone est utilisé comme adresse
            'package_description' => $request->input('package_description', 'Description du colis'),
            'package_price'       => $request->input('parcel_amount'),
            'delivery_fee'        => $request->input('delivery_amount'),
            'status'              => $status,
        ]);

        return redirect()->route('reports')->with('success', 'Colis ajouté avec succès.');
    }

    public function destroy($id)
    {
        $parcel = Parcel::findOrFail($id);

        // Vérifier si le colis appartient bien à la compagnie de l'utilisateur
        if ($parcel->company_id !== auth()->user()->company_id) {
            return redirect()->route('reports')->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce colis.');
        }


        $parcel->delete();

        return redirect()->route('reports')->with('success', 'Colis supprimé avec succès.');
    }

    /**
     * Récupère les clients de la compagnie de l'utilisateur connecté et les zones de livraison.
     */
    public function getClientsZones(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        // Récupérer les clients de la compagnie
        $clients = [];
        if ($company) {
            $clients = Client::where('company_id', $company->company_id)->pluck('name');
        }

        // Récupérer toutes les zones de livraison
        $zones = DeliveryZone::pluck('zone_name');

        return response()->json([
            'clients' => $clients,
            'zones'   => $zones,
        ]);
    }



    public function pdfPage(Request $request)
    {
        return view('pdf.reporting');
    }


    // Telecharger et filtrer les colis
    public function downloadPdf(Request $request)
    {
        // Optionnel : Augmenter le temps d'exécution si nécessaire
        set_time_limit(120);

        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer la compagnie de l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();
        if (!$company) {
            return redirect()->back()->with('error', 'Aucune compagnie associée à votre compte.');
        }

        $hideDeliveryAmount = $request->has('hide_delivery_amount') && $request->input('hide_delivery_amount') == 'on';

        // Récupérer les filtres envoyés par le formulaire
        $deliveryDate = $request->input('delivery_date');
        $clientFilter = $request->input('client');
        $statusFilter = $request->input('status');

        // Mapping des statuts
        $statusMapping = [
            'En cours' => 'pending',
            'En attente' => 'in_transit',
            'Livrée'     => 'delivered',
            'Retournée'  => 'canceled',
        ];

        // Récupérer tous les clients de l'entreprise
        $companyClients = Client::where('company_id', $company->company_id)->get();

        // Construire la requête
        $query = Parcel::with(['client', 'deliveryZone'])
            ->where('company_id', $company->company_id);

        // Filtre par date si fournie
        if (!empty($deliveryDate)) {
            try {
                // Parse la date envoyée et ajout une heure si nécessaire
                $date = Carbon::parse($deliveryDate)->setTime(11, 0, 0); // Fixer l'heure à 11h

                // Calculer la période de 11h du jour suivant
                $startDate = $date;
                $endDate = $date->copy()->addDay()->setTime(11, 0, 0); // Le jour suivant à 11h

                // Appliquer le filtre sur la plage horaire
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // Gestion d'erreur si la date est invalide
            }
        }

        // Filtrer par client si différent de "Tous les clients"
        if (!empty($clientFilter) && $clientFilter !== 'Tous les clients') {
            $query->whereHas('client', function ($q) use ($clientFilter) {
                $q->where('name', $clientFilter);
            });
        }

        // Filtrer par statut si différent de "Tous les statuts"
        if (!empty($statusFilter) && $statusFilter !== 'Tous les statuts') {
            $status = $statusMapping[$statusFilter] ?? null;
            if ($status) {
                $query->where('status', $status);
            }
        }

        // Récupération des colis filtrés
        $parcels = $query->get();

        // Rediriger vers la page PDF avec les données
        return view('pdf.reporting', compact('parcels', 'company', 'deliveryDate', 'clientFilter', 'statusFilter', 'hideDeliveryAmount', 'companyClients'));
    }

}
