<?php

namespace App\Livewire;

use Livewire\Component;

class Role extends Component
{
    public $role;
    public $creer = false;
    public function mount($role)
    {
        $this->role = $role;
    }
    public function toggle()
    {
        $this->creer = !$this->creer;
    }

    public function render()
    {
        return view('livewire.role');
    }
}
