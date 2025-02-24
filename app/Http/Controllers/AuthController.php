<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;


class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function loginForm()
    {
        return view('auth.login');
    }

    public function logoutForm()
    {
        return view('auth.logout');
    }

    public function logout(Request $request)
    {
        // Supprimer les sessions utilisateur
        Session::forget('manager');

        // Déconnecter l'utilisateur
        auth()->logout();

        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('logout')->with('success', 'Vous avez été déconnecté.');
    }

    // Afficher le formulaire d'inscription
    public function registerForm()
    {
        return view('auth.register');
    }

    // Gérer l'inscription
    public function register(Request $request)
    {
        try {
            DB::beginTransaction(); // Démarrer une transaction

            // Code de validation pour l'utilisateur
            $validation_code = rand(100000, 999999);
            $role = 'manager';
            $verified = '1';
            $status = 'active';

            // Créer un nouvel utilisateur
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $role,
                'validation_code' => $validation_code,
                'is_verified' => $verified,
                'status' => $status,
            ]);

            if (!$user) {
                throw new \Exception('Erreur lors de la création de l\'utilisateur.');
            }

            // Créer la compagnie de l'utilisateur
            $company = Company::create([
                'user_id' => $user->id,
                'name' => $request->structure_name,
            ]);

            if (!$company) {
                throw new \Exception('Erreur lors de la création de la compagnie.');
            }

            // Trouver l'abonnement "Starter"
            $starterSubscription = Subscription::find(1);

            if (!$starterSubscription) {
                throw new \Exception('Abonnement "Starter" non trouvé.');
            }

            // Générer un transaction_id avec des lettres et des chiffres
            $transactionId = 'TX' . strtoupper(bin2hex(random_bytes(5)));

            // Créer une entrée de paiement pour l'abonnement "Starter"
            $payment = Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $starterSubscription->id ?? 1,
                'amount' => $starterSubscription->price ?? 0,
                'transaction_id' => $transactionId ?? null,
                'payment_method' => 'free',
                'payment_status' => 'completed',
                'paid_at' => now(),
            ]);


            if (!$payment) {
                throw new \Exception('Erreur lors de la création du paiement.');
            }

            // Associer l'utilisateur à l'abonnement Starter via UserSubscription
            $userSubscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_id' => $starterSubscription->id,
                'start_date' => now(),
                'end_date' => now()->addDays($starterSubscription->duration),
                'status' => 'active',
            ]);

            if (!$userSubscription) {
                throw new \Exception('Erreur lors de l\'attribution de l\'abonnement à l\'utilisateur.');
            }

            DB::commit(); // Valider la transaction si tout est bon

            return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès. Connectez-vous maintenant !');
        } catch (\Exception $e) {
            DB::rollBack(); // Annuler tous les enregistrements en cas d'erreur
            Log::error('Erreur lors de l\'inscription : ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer plus tard.']);
        }
    }






    // Gérer la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérifier l'existence de l'utilisateur et la validité du mot de passe
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['error' => "Identifiants incorrects."]);
        }

        // Vérifier si le compte est vérifié
        if ($user->is_verified != 1) {
            return back()->withErrors(['error' => "Votre compte n'est pas encore vérifié."]);
        }

        // Vérifier le rôle (exclure client et livreur)
        if (in_array($user->role, ['client', 'livreur'])) {
            return back()->withErrors(['error' => "Vous n'êtes pas autorisé à accéder à cette plateforme."]);
        }

        // Récupérer la compagnie du manager
        $company = Company::where('user_id', $user->id)->first();

        // Stocker les infos du manager en session
        Session::put('manager', [
            'id' => $user->id,
            'name' => $user->full_name,
            'company_name' => $company ? $company->name : 'Aucune compagnie',
        ]);

        // Vérifier si "Se souvenir de moi" est coché
        $remember = $request->has('remember');

        // Connecter l'utilisateur en utilisant le flag "remember"
        auth()->login($user, $remember);

        // Gérer le cookie pour préremplir l'adresse e-mail
        if ($remember) {
            // Le cookie sera stocké pendant 30 jours
            Cookie::queue('remember_email', $user->email, 60 * 24 * 30);
        } else {
            Cookie::queue(Cookie::forget('remember_email'));
        }

        return redirect()->route('dashboard')->with('success', "Vous êtes maintenant connecté $user->full_name.");
    }
}
