<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Document;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',
            'service' => 'required|int',
            'role' => 'required|int',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'service_id' => $validatedData['service'],
            'role_id' => $validatedData['role'],
        ]);

        return redirect()->back()->with('success', 'Utilisateur ajouté avec succès.');
    }

    public function store_role(Request $request): \Illuminate\Http\RedirectResponse
    {

        $validatedData = $request->validate([
            'nom' => 'required|string|min:3|unique:roles',
        ]);

        $role = Role::create([
            'nom' => $validatedData['nom'],
        ]);


        return redirect()->back()->with('success', 'Service ajouté avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $services = Service::all();
        $roles = Role::all();

        return view('users.edit', compact('user',  'services', 'roles'));
    }

    public function show_profile($id)
    {
        $user_profile = User::findOrFail($id);
        return view('profile', compact('user_profile'));
    }


   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validation des données
    $validatedData = $request->validate([
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email,' . $id,
        'service' => 'required|int',
        'role' => 'required|int',
        'password' => 'nullable|string|min:8|confirmed', // nouveau champ de validation
    ]);

    // Mise à jour des informations
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->service_id = $validatedData['service'];
    $user->role_id = $validatedData['role'];

    // Si un nouveau mot de passe est fourni, on le met à jour
    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    return redirect()->route('user')->with('success', 'Utilisateur modifié avec succès.');
}


    public function update_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Mise à jour des informations de l'utilisateur
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();

        return redirect()->route('profile', $id)->with('success', 'Modification réussie.');
    }

    public function update_password(Request $request)
    {

        // Valider les données
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'min:8',
            'confirmed', // new_password_confirmation doit être envoyé
        ]);

        // Vérifier si le mot de passe actuel est correct
        if (!Hash::check($validatedData['current_password'], $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        // Mettre à jour le mot de passe de l'utilisateur
        $request->user()->update([
            'password' => Hash::make($validatedData['new_password']),
        ]);

        return back()->with('succes', 'Mot de passe changé avec succès !');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->route('user')->with('success', 'Utilisateur supprimé avec succès.');
        }

        return redirect()->route('user')->with('error', 'Utilisateur introuvable.');
    }

    public function index()
    {
        $users = User::all();
        $users_tag = User::where('id', '!=', Auth::id())->whereDoesntHave('role', function ($query) {
            $query->where('nom', 'SuperAdministrateur');
        })->get();
        $services = Service::all();
        $documents = Document::all();
        $roles = Role::all();

        return view('users', compact('users', 'users_tag', 'services', 'documents', 'roles'));
    }

    public function searchForSelect2(Request $request)
    {
        $term = $request->input('term');
        $users = User::where('name', 'LIKE', '%' . $term . '%')
            ->select('id', 'name as text')
            ->get();
        return response()->json($users);
    }
}
