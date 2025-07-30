<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        Role::create([
            'nom' => $validatedData['role_name'],
        ]);

        return redirect()->back()->with('success', 'Rôle créé avec succès.');
    }
}
