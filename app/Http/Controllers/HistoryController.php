<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Service;
use App\Models\Role;
use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function exportPDF(Request $request)
    {
        $user = Auth::user();
        $service = $user->service;
        $searchUserId = $request->input('user_id');

        $query = ActivityLog::query();

        if ($searchUserId) {
            $query->where('user_id', $searchUserId);
        }

        if (!($user->role->nom == "SuperAdministrateur" || $user->role->nom == "Administrateur")) {
            $query->whereIn('description', $service->documents()->pluck('nom'))->where(function (Builder $query) use ($user) {
                $query->whereIn('description', $user->confidentialite()->pluck('nom'))->orWhere('confidentiel', false);
            });
        }

        $activities = $query->with('user')->latest()->get();

        // Charger la vue PDF avec les données
        $pdf = Pdf::loadView('history-pdf', compact('activities'));

        // Télécharger le PDF
        return $pdf->download('historique-des-activites.pdf');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $service = $user->service;
        $searchUserId = $request->input('user_id');

        $query = ActivityLog::query();

        if ($searchUserId) {
            $query->where('user_id', $searchUserId);
        }

        if ($user->role->nom == "SuperAdministrateur" || $user->role->nom == "Administrateur") {
            // Les administrateurs voient tout (potentiellement filtré par utilisateur)
        } else {
            $query->whereIn('description', $service->documents()->pluck('nom'))->where(function (Builder $query) use ($user) {
                $query->whereIn('description', $user->confidentialite()->pluck('nom'))->orWhere('confidentiel', false);
            });
        }

        $activities = $query->latest()->paginate(10);

        $users = User::all();
        $services = Service::all();
        $roles = Role::all();
        $documents = Document::all();

        return view('history', compact('activities', 'users', 'services', 'roles', 'documents', 'searchUserId'));
    }
}
