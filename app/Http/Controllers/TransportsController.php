<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;
use App\Models\Driver;
use App\Models\Company;


class TransportsController extends Controller
{

    public function index()
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

        // Récupérer les moyens de transport de l'entreprise
        $transports = Transport::where('company_id', $company->company_id)->paginate(7);


        // Récupérer les livreurs associés à l'entreprise
        $drivers = Driver::where('company_id', $company->company_id)->get();

        // Passer les données à la vue
        return view('pages.transports-list', compact('company', 'transports', 'drivers', 'user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|string',
            'color'  => 'required|string',
            'status' => 'required|string',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        $user = auth()->user();

        // Récupérer l'entreprise associée à l'utilisateur
        $company = $user->company; // Assurez-vous que la relation "company" est bien définie dans le modèle User

        if (!$company) {
            return back()->with('error', 'Aucune société associée à cet utilisateur.');
        }

        // Pour stocker le nom du moyen, on utilise ici le champ "details" (ou ajoutez une colonne "name" dans la table)
        Transport::create([
            'company_id'     => $company->company_id, // Utiliser l'ID de l'entreprise
            'transport_type' => $request->type,       // Correspond au type (ex. : velo, moto, etc.)
            'color'          => $request->color,
            'statut'         => $request->status,     // Correspond au statut (disponible, en_utilisation, etc.)
            'driver_id'      => $request->driver_id,
            'details'        => $request->name,       // Stocker le "nom" du moyen dans "details"
        ]);

        return back()->with('success', 'Moyen de transport ajouté avec succès.');
    }




    public function destroy($id)
    {
        $transport = Transport::findOrFail($id);


        $user = auth()->user();

        // Récupérer la compagnie associée à l'utilisateur connecté
        $company = Company::where('user_id', $user->id)->first();


        // Vérifier si le colis appartient bien à la compagnie de l'utilisateur
        if ($transport->company_id !== $company->company_id) {
            return redirect()->route('parcels-list')->with('warning', 'Vous n\'avez pas l\'autorisation de supprimer ce colis.');
        }


        $transport->delete();
        return back()->with('success', 'Moyen de transport supprimé.');
    }
}
