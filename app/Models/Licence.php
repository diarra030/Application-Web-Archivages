<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Licence extends Model
{
    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'licence_key',
        'expiration_date',
        'verifier',
        'created_at',
        'updated_at',
    ];

    /**
     * Vérifier si la licence est valide.
     *
     * @return bool
     */
    public static function isValid()
    {
        $licence = Licence::where('expiration_date', '>=', Carbon::now())->first();
        return $licence !== null;
    }

    public static function isVerified()
    {
        $valide = Licence::where('verifier', true)->first();
        return $valide !== null;
    }
}
