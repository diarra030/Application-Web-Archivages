<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Role;

class RegisterController extends Controller
{
    public function store(Request $request)
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

        return view('auth.login')->with('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');
    }

    public function index()
    {
        $services = Service::all();
        $roles = Role::all();

        return view('register', compact('services', 'roles'));
    }
}
