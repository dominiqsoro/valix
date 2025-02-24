<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use Carbon\Carbon;


class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // Recherche d'un colis via son identifiant (code de tracking)
    public function searchParcel(Request $request)
    {
        $trackingCode = $request->input('tracking_code');

        $parcel = Parcel::where('identifiant', $trackingCode)
            ->with(['client', 'deliveryZone', 'company'])
            ->first();


        if ($parcel) {
            // Définition des étapes et de la progression
            $progress = [
                'in_transit' => 50,   // En attente -> 25%
                'pending' => 75, // En cours -> 75%
                'delivered' => 100, // Livrée -> 100%
                'canceled' => 100,    // Retournée -> 0%
            ];

            // Définition de la date de livraison estimée en français
            Carbon::setLocale('fr');
            $formattedDate = $parcel->created_at->translatedFormat('l d F Y');
            $deliveryDate = $parcel->status === 'canceled'
                ? 'À déterminer'
                : "{$formattedDate} avant 20h";



            return response()->json([
                'success' => true,
                'parcel' => [
                    'tracking_code' => $parcel->identifiant,
                    'client_name' => $parcel->client->name ?? 'Non spécifié',
                    'delivery_address' => $parcel->delivery_address,
                    'zone' => $parcel->deliveryZone ? $parcel->deliveryZone->name : 'Non spécifié',
                    'company' => $parcel->company ? $parcel->company->name : 'Non spécifié',
                    'package_description' => $parcel->package_description,
                    'package_price' => $parcel->package_price,
                    'delivery_fee' => $parcel->delivery_fee,
                    'status' => $parcel->status ?? 'pending',
                    'progress' => $progress[$parcel->status] ?? 0,
                    'delivery_date' => $deliveryDate, // Date formatée
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aucun colis trouvé avec ce code.'
            ]);
        }
    }



}
