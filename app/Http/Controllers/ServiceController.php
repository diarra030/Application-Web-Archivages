<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {

        $services = Service::all();

        $totalEmployes = $services->sum(function($service) {
            return count($service->users);
        });

        $totalDocuments = Document::all()->count();
        return view(('service'), compact('services', 'totalEmployes', 'totalDocuments'));
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if ($service) {
            $service->delete();
            return redirect()->route('service')->with('success', 'Service supprimé avec succès.');
        }

        return redirect()->route('service')->with('error', 'Service introuvable.');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|unique:services,nom,'.$id,
        ]);

        // Mise à jour des informations de l'utilisateur
        $service->nom = $validatedData['name'];
        $service->save();

        return redirect()->route('service', $id)->with('success', 'Modification réussie.');
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $service = Service::findOrFail($id);
        $users = User::all();
        $users_tag = User::where('id', '!=', Auth::id())->whereDoesntHave('role', function ($query) { $query->where('nom', 'SuperAdministrateur'); }) ->get();

        return view('service.show', compact('service', 'users', 'users_tag'));
    }

    public function identUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user-input' => 'required|string',
        ]);

        $service = Service::findOrFail($id);
        $usersarray = explode(' ', $validatedData['user-input']);

        $users = array_unique($usersarray);

        // Ignorer les deux premiers caractères de chaque élément
        $users = array_map(function ($user) {
            return substr($user, 2); // Enlève les 2 premiers caractères
        }, $users);

        $existingUsers = [];

        foreach ($users as $userId) {
            // Enregistrez chaque utilisateur dans la base de données
            $user = User::where('email', $userId)->first();
            if($user){
                $exists = $service->identificate()->where('user_id', $user->id)->exists();
                if(!$exists){
                    $service->identificate()->attach($user);

                } else {
                    $existingUsers[] = $user->email;
                }
            }
        }

        if(count($existingUsers) == 0){
            return redirect()->back()->with('success', 'Identification reussie.');
        } elseif (count($existingUsers) == count($users)){
            return redirect()->back()->with('error', 'Ces utilisateurs sont deja identifiés dans le service.');
        } elseif (count($users) > count($existingUsers) and count($existingUsers) > 0){
            if(count($existingUsers) == 1){
                return redirect()->back()->with('success', 'Identification reussie sauf ' . implode(', ', $existingUsers) . ' qui est deja identifiés dans le service.');
            } else{
                return redirect()->back()->with('success', 'Identification reussie sauf ' . implode(', ', $existingUsers) . ' qui sont deja identifiés dans le service.');
            }
        }
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:services,nom,',
        ]);

        $service = Service::create([
            'nom' => $validatedData['name'],
        ]);

        return redirect()->back()->with('success', 'Service ajouté avec succès.');

    }
}
