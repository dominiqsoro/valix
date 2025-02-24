<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Parcel;
use App\Models\Client;
use App\Models\Company;
use App\Models\DeliveryZone;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            // Si l'utilisateur n'a pas de compagnie associée, on retourne une vue vide ou on gère l'erreur
            return view('pages.dashboard', [
                'parcels' => collect(),
                'clients' => collect()
            ])->with('error', 'Aucune compagnie associée à votre compte.');
        }

        // Récupérer les 5 derniers colis de la compagnie avec les infos associées (client et zone)
        $parcels = Parcel::with(['client', 'deliveryZone'])
            ->where('company_id', $company->company_id)
            ->latest()  // Trier par la date la plus récente
            ->take(5)   // Limiter à 5 colis
            ->get();

        // Récupérer les 5 derniers clients de la compagnie, incluant leurs informations utilisateur et zone de livraison
        $clients = Client::with(['user', 'deliveryZone'])
            ->where('company_id', $company->company_id)
            ->latest()  // Trier par date d'enregistrement, les plus récents en premier
            ->take(5)   // Limiter à 5 clients
            ->get();


        // Récupérer tous les clients de la compagnie
        $companyClients = Client::where('company_id', $company->company_id)->get();

        $today = Carbon::today();
        $parcelStats = Parcel::where('company_id', $company->company_id)
            ->whereDate('created_at', $today)
            ->selectRaw('COUNT(*) as totalParcelsToday, SUM(delivery_fee) as totalDeliveryAmount, SUM(package_price) as totalParcelAmount')
            ->first();

        // Nombre total de clients
        $totalClients = Client::where('company_id', $company->company_id)->count();

        // Somme des montants des livraisons du jour
        $totalDeliveryAmount = Parcel::where('company_id', $company->company_id)
            ->whereDate('created_at', Carbon::today())
            ->sum('delivery_fee');

        // Somme des montants des colis du jour
        $totalParcelAmount = Parcel::where('company_id', $company->company_id)
            ->whereDate('created_at', Carbon::today())
            ->sum('package_price');

        // Nombre de colis du jour
        $totalParcelsToday = Parcel::where('company_id', $company->company_id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('pages.dashboard', compact('parcels', 'clients', 'companyClients', 'totalClients', 'totalDeliveryAmount', 'totalParcelAmount', 'totalParcelsToday',));
    }


}
