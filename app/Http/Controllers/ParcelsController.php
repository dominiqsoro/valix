<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Client;
use App\Models\DeliveryZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Company;

class ParcelsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            // Si l'utilisateur n'a pas de compagnie associée, on retourne une vue vide ou on gère l'erreur
            return view('pages.parcels-list', [
                'parcels' => collect(),
                'clients' => collect()
            ])->with('error', 'Aucune compagnie associée à votre compte.');
        }

        $companyClients = Client::where('company_id', $company->company_id)->get(); // Récupère tous les clients (à adapter selon ta logique)

        // Récupérer les colis de la compagnie avec les infos associées (client et zone)
        $parcels = Parcel::with(['client', 'deliveryZone'])
            ->where('company_id', $company->company_id)
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        // Récupérer les clients de la compagnie
        $clients = Client::where('company_id', $company->company_id)->get();

        return view('pages.parcels-list', compact('parcels', 'clients', 'companyClients'));
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
            ->with('client', 'deliveryZone')
            ->orderBy('created_at', 'desc')
            ->get();

        $companyClients = Client::where('company_id', $companyId)->get();

        return view('pages.parcels-list', compact('parcels', 'companyClients'));
    }



    public function updateStatus(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();
        if (!$company) {
            return redirect()->route('parcels.index')->with('error', 'Aucune compagnie associée à votre compte.');
        }

        // Validation des données
        $request->validate([
            'parcel_id' => 'required|exists:parcels,id',
            'status' => 'required|in:in_transit,pending,delivered,canceled',
        ]);

        // Récupérer le colis
        $parcel = Parcel::findOrFail($request->parcel_id);

        // Vérifier si le colis appartient à la compagnie de l'utilisateur connecté
        if ($parcel->company_id !== $company->company_id) {
            return redirect()->route('parcels.index')->with('error', 'Ce colis n\'appartient pas à votre compagnie.');
        }

        // Mettre à jour le statut du colis
        $parcel->status = $request->status;
        $parcel->save();

        // Retourner à la page des colis avec un message de succès
        return redirect()->route('parcels-list')->with('success', 'Le statut du colis a été mis à jour avec succès.');
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
            'En cours' => 'pending',
            'En attente' => 'in_transit',
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

        return redirect()->route('parcels-list')->with('success', 'Colis ajouté avec succès.');
    }


    public function destroy($id)
    {
        $parcel = Parcel::findOrFail($id);

        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        // Vérifier si le colis appartient bien à la compagnie de l'utilisateur
        if ($parcel->company_id !== $company->company_id) {
            return redirect()->route('parcels-list')->with('warning', 'Vous n\'avez pas l\'autorisation de supprimer ce colis.');
        }


        $parcel->delete();

        return redirect()->route('parcels-list')->with('success', 'Colis supprimé avec succès.');
    }


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
}
