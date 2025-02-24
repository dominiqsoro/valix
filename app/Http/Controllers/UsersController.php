<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Company;
use App\Models\Transport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class UsersController extends Controller
{
    // Récupérer tous les managers
    public function managers()
    {
        $managers = User::where('role', 'manager')->get();
        return view('pages.users-managers', compact('managers'));
    }

    // Récupérer les clients de la compagnie de l'utilisateur connecté
    public function clients()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
        // Récupérer l'entreprise associée à l'utilisateur connecté (manager)
        $company = Company::where('user_id', $user->id)->first();

        // Vérifier si l'entreprise existe
        if (!$company) {
            // Vous pouvez gérer le cas où aucune entreprise n'est trouvée
            return redirect()->back()->withErrors('Aucune entreprise trouvée pour cet utilisateur.');
        }

        // Récupérer les clients appartenant à la compagnie (en utilisant l'ID de la compagnie)
        $clients = Client::where('company_id', $company->company_id)->paginate(7);


        return view('pages.users-clients', compact('clients', 'company'));
    }

    // Récupérer les livreurs et transports de la compagnie de l'utilisateur connecté
    public function drivers()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer l'entreprise associée à l'utilisateur connecté (manager)
        $company = Company::where('user_id', $user->id)->first();

        // Vérifier si l'entreprise existe
        if (!$company) {
            return redirect()->back()->withErrors('Aucune entreprise trouvée pour cet utilisateur.');
        }


        // Récupérer les livreurs et les transports de la compagnie
        // Récupérer les livreurs avec leur transport
        $drivers = Driver::where('company_id', $company->company_id)
            ->with('transport') // Charger la relation transport
            ->paginate(7);

        $transports = Transport::where('company_id', $company->company_id)->get();

        return view('pages.users-drivers', compact('drivers', 'company', 'transports'));
    }



    // API : Récupérer les clients et livreurs de la compagnie en JSON
    public function getByCompany()
    {
        $companyId = auth()->user()->company_id;

        $clients = Client::where('company_id', $companyId)->select('id', 'name')->get();
        $drivers = Driver::where('company_id', $companyId)->with('user:id,full_name')->get();

        return response()->json([
            'clients' => $clients,
            'drivers' => $drivers
        ]);
    }


    // 📌 Fonction pour enregistrer un nouveau client
    public function storeClient(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'location' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Le nom complet est requis.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.required' => 'Le téléphone est requis.',
            'phone.unique' => 'Ce numéro est déjà utilisé.',
            'location.required' => 'L\'adresse est requise.',
        ]);


        // Générer l'email à partir du nom
        $generatedEmail = Str::slug($request->full_name) . '@valix.com'; // Remplacer 'valix.com' par ton domaine ou un domaine par défaut

        // Récupérer l'ID de la compagnie depuis le formulaire
        $companyId = $request->input('company_id');

        // Utilisation du mot de passe par défaut
        $defaultPassword = 'Valix2025@';

        // Création de l'utilisateur
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $generatedEmail,
            'phone' => $request->phone,
            'password' => Hash::make($defaultPassword), // Hash du mot de passe
            'role' => 'client',
        ]);

        // Création du client
        Client::create([
            'user_id' => $user->id,
            'company_id' => $companyId, // Associe le client à la compagnie de l'utilisateur connecté
            'name' => $request->full_name,
            'location' => $request->location,
        ]);

        return back()->with('success', 'Client ajoutée avec succès..');
    }





    public function destroyClient($id)
    {
        // Récupérer le client par son identifiant ou renvoyer une erreur 404 s'il n'existe pas
        $client = Client::findOrFail($id);

        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        // Vérifier si le client appartient bien à la compagnie de l'utilisateur
        if ($client->company_id !== $company->company_id) {
            return redirect()->route('pages.users-clients')->with('warning', 'Vous n\'avez pas l\'autorisation de supprimer ce colis.');
        }


        // Optionnel : si vous souhaitez également supprimer l'utilisateur associé au client, décommentez la ligne suivante :
        $client->user()->delete();

        // Suppression du client
        $client->delete();

        return redirect()->back()->with('success', 'Client supprimé avec succès.');
    }



    public function storeDriver(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'location' => 'string',
            'moto'  => 'number',
        ]);

        // Générer l'email à partir du nom
        $generatedEmail = Str::slug($request->name) . '@valix.com'; // Remplacer 'valix.com' par ton domaine ou un domaine par défaut


        // Utilisation du mot de passe par défaut
        $defaultPassword = 'Valix2025@';
        // Récupérer l'ID de la compagnie depuis le formulaire
        $companyId = $request->input('company_id');

        $user = User::create([
            'full_name' => $request->name,
            'email' => $generatedEmail,
            'phone' => $request->phone,
            'password' => Hash::make($defaultPassword), // Hash du mot de passe
            'role' => 'driver',
        ]);

        // Création du livreur
        Driver::create([
            'user_id' => $user->id,
            'company_id' => $companyId, // Associe le livreur à la compagnie de l'utilisateur connecté
            'transport_id' => $request->moto,
            'location' => $request->location,
        ]);


        return redirect()->back()->with('success', 'Livreur ajouté avec succès !');
    }

    public function destroyDriver($id)
    {
        // Récupérer le livreur ou renvoyer une erreur 404
        $driver = Driver::findOrFail($id);

        $user = auth()->user();


        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();

        // Vérifier si le livreur appartient bien à la compagnie de l'utilisateur
        if ($driver->company_id !== $company->company_id) {
            return redirect()->route('pages.users-drivers')->with('warning', 'Vous n\'avez pas l\'autorisation de supprimer ce colis.');
        }


        // Supprimer l'utilisateur associé au livreur (si existant)
        if ($driver->user) {
            $driver->user->delete();
        }

        // Supprimer le livreur
        $driver->delete();

        return redirect()->back()->with('success', 'Livreur supprimé avec succès.');
    }
}
