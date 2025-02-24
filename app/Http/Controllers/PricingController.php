<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;

class PricingController extends Controller
{
    public function index()
    {
        // Récupérer les abonnements disponibles
        $subscriptions = Subscription::where('status', 'active')->get();

        // Récupérer l'abonnement actuel de l'utilisateur connecté
        $user = auth()->user();

        $userSubscription = UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();


        // Passer les données à la vue
        return view('pages.pricing', [
            'subscriptions' => $subscriptions,
            'userSubscription' => $userSubscription
        ]);
    }
}
