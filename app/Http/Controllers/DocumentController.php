<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Document;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function getDocuments($serviceId)
    {
        $users_tag = User::where('id', '!=', Auth::id())->whereDoesntHave('role', function ($query) {
            $query->where('nom', 'SuperAdministrateur');
        })->get();

        // Trouver le service et charger les documents associés
        if ($serviceId == 0) {
            $perPage = request('per_page', 10);
            $documents = Document::doesntHave('services')->orderBy('created_at', 'desc')->paginate($perPage);
            $users = User::all();

            return view('documentShow', compact('documents', 'users', 'users_tag'));
        } else {

            $service = Service::find($serviceId);
            $users = User::all();

            if (!$service) {
                return response()->json(['error' => 'Erreur Service introuvable'], 404);
            }

            $perPage = request('per_page', 10);

            $user = User::findOrFail(Auth::user()->id);

            if ($user->role->nom == "SuperAdministrateur" | $user->role->nom == "Administrateur") {
                $documents = $service->documents()->orderBy('created_at', 'desc')->paginate($perPage);
            } else {
                // Récupérer les documents associés
                $documents = $service->documents()->where('confidentiel', false)->orwhereIn('nom', $user->confidentialite()->pluck('nom'))->orderBy('created_at', 'desc')->paginate($perPage);
            }

            return view('documentShow', compact('documents', 'service', 'users', 'users_tag'));
        }
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $nom = $document->nom;
        $document->delete();

        $activity = ActivityLog::create([
            'action' => '❌ Document supprimé',
            'description' => $nom,
            'icon' => '❌',
            'user_id' => Auth::user()->id,
            'confidentiel' => $document->confidentiel,
        ]);

        return redirect()->back()->with('success', 'Document ' . $nom . ' supprimé avec succès');
    }

    public function bulkDelete(Request $request)
    {
        // Valider la requête pour s'assurer que des IDs sont envoyés
        $validatedData = $request->validate([
            'document_ids' => 'required|array',
            'document_ids.*' => 'exists:documents,id',
        ]);

        


        // Supprimer les documents sélectionnés
        Document::whereIn('id', $request->document_ids)->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Les documents sélectionnés ont été supprimés.');
    }


    public function index()
    {
        $service = Auth::user()->service;
        $serviceIdent = Auth::user()->identificate;
        $documents = Document::all();
        $documentGene = Document::doesntHave('services')->get();
        $services = Service::all();
        $servicePaginate=Service::paginate(12);
        $totalDocuments = Document::all()->count();


        return view('document', compact('documents', 'documentGene', 'service','servicePaginate', 'serviceIdent', 'services', 'totalDocuments'));
    }
}
