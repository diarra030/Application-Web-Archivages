<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Tag extends Component
{
    public $document;
    public $query = ''; // Saisie utilisateur
    public $users = []; // Utilisateurs correspondants
    public $selectedUsers = []; // Liste des utilisateurs sélectionnés

    public function mount($document)
    {
        $this->document = $document;
    }

    public function updatedQuery()
    {
        // Si l'utilisateur tape un #
        if (str_starts_with($this->query, '#')) {
            // Rechercher des utilisateurs correspondant à la saisie
            $searchTerm = substr($this->query, 1); // Supprimer #
            $this->users = User::where('name', 'like', "%{$searchTerm}%")->take(5)->get()->toArray();
        } else {
            $this->users = [];
        }
    }

    public function selectUser($userId)
    {
        // Ajouter un utilisateur sélectionné
        $user = User::find($userId);
        if ($user && !in_array($user, $this->selectedUsers)) {
            $this->selectedUsers[] = $user;
        }

        // Réinitialiser la saisie et suggestions
        $this->query = '';
        $this->users = [];
    }

    public function removeUser($userId)
    {
        // Supprimer un utilisateur sélectionné
        $this->selectedUsers = array_filter($this->selectedUsers, function ($user) use ($userId) {
            return $user['id'] != $userId;
        });
    }

    public function render()
    {
        return view('livewire.tag');
    }
}
