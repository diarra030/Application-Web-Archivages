<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class ServiceDocumentsTable extends Component
{


    use WithPagination;

    public $service;
    public $allusers;
    public $showTableDoc = false;
    public $showTableUser = false;
    public $showTableUserIdent = false;

    public function mount($service, $allusers)
    {
        $this->service = $service;
        $this->allusers = $allusers;
    }

    public function retirerDocument($documentId)
    {
        $document = $this->service->documents()->find($documentId);

        if ($document) {
            $this->service->documents()->detach($documentId); // Suppression de la liaison dans la table pivot
            session()->flash('success', 'Document retiré avec succès.');
        } else {
            session()->flash('error', 'Action non aboutie.');
        }
    }

    public function retirerUser($userid)
    {
        $user = $this->service->identificate()->find($userid);

        if ($user) {
            $this->service->identificate()->detach($userid); // Suppression de la liaison dans la table pivot
            session()->flash('success', 'Utilisateur retiré avec succès.');
        } else {
            session()->flash('error', 'Utilisateur non aboutie.');
        }
    }

    public function render()
    {
        if(Auth::user()->role->nom == 'SuperAdministrateur' | Auth::user()->role->nom == 'Administrateur') {
            $documents = $this->service->documents()
            ->paginate(10);

            $recentDocuments = $this->service->documents()
            ->orderBy('created_at', 'desc') // Trier par date d'ajout, du plus récent au plus ancien
            ->take(5) // Limiter à 5 documents
            ->get(); // Récupérer les résultats

        } else {
            $user = User::find(Auth::user()->id);
            $documents = $this->service->documents()
            ->where('confidentiel', false)
            ->orwhereIn('nom', $user->confidentialite()->pluck('nom'))
            ->paginate(10);

            $recentDocuments = $this->service->documents()
            ->orderBy('created_at', 'desc') // Trier par date d'ajout, du plus récent au plus ancien
            ->where('confidentiel', false)
            ->orwhereIn('nom', $user->confidentialite()->pluck('nom'))
            ->take(5) // Limiter à 5 documents
            ->get(); // Récupérer les résultats

        }

        $users = $this->service->users()
            ->paginate(10);

        $usersIdent = $this->service->identificate()
            ->paginate(10);

        return view('livewire.service-documents-table', ['documents' => $documents, 'users' => $users, 'usersIdent' => $usersIdent, 'recentDocuments' => $recentDocuments]);
    }
}
