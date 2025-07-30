<?php

namespace App\Livewire;

use Livewire\Component;

class User extends Component
{

    public $users;
    public $services;
    public $documents;
    public $roles;
    public $users_tag;
    public $edit = false;


    public $search_var = '';

    public function mount($users, $services, $documents, $roles, $users_tag)
    {
        $this->users = $users;
        $this->users_tag = $users_tag;
        $this->services = $services;
        $this->documents = $documents;
        $this->roles = $roles;
    }

    public function updateUser()
    {
        $this->validate();

        // Mise à jour de l'utilisateur
        $user = User::find($this->userId);

        if ($user) {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ]);

            // Message de succès ou autre action après la mise à jour
            session()->flash('message', 'Utilisateur mis à jour avec succès.');
        }
    }

    public function editer()
    {

        $this->edit = !$this->edit;
    }


    public function render()
    {
        return view('livewire.user');
    }
}
