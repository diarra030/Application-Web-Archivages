<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\User;
use App\Models\Service;
use Livewire\Component;

class StatGeneral extends Component
{
    public $documents;
    public $users;
    public $services;

    public function mount()
    {
        // Simulez les données. Remplacez-les par vos requêtes de base de données.
        $this->documents = Document::count();
        $this->users = User::count();
        $this->services = Service::count();
    }

    public function render()
    {
        return view('livewire.stat-general');
    }
}
