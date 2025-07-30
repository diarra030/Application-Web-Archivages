<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;

class LicenceController extends Controller
{
    public function verify(Request $request)
    {
        $ValidatedData = $request->validate([
            'licence_key' => 'required|string',
        ]);

        $licence = Licence::where('licence_key', $ValidatedData['licence_key'])
            ->where('expiration_date', '>=', now())
            ->first();

        if ($licence) {
            $licence->verifier = true;
            $licence->save();
            return redirect()->back()->with('success', 'Licence vérifiée avec succès.');
        } else {
            return redirect()->back()->with('error', 'Clé de licence invalide ou expirée.');
        }
    }
}
