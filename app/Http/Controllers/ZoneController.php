<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryZone;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = DeliveryZone::orderBy('zone_name', 'asc')->paginate(8); // Trier par ordre alphabétique
        return view('pages.zones-list', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:delivery_zones,zone_name',
        ]);


        DeliveryZone::create([
            'zone_name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Zone de livraison ajoutée avec succès.');
    }

    public function destroy($id)
    {
        $zone = DeliveryZone::findOrFail($id);
        $zone->delete();

        return redirect()->back()->with('success', 'Zone de livraison supprimée avec succès.');
    }
}
