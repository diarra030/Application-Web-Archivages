<?php

namespace App\Livewire;

use Livewire\Component;

class RoleSearch extends Component
{
    public $search = '';

    public function deleteRole($id)
    {
        $role = \App\Models\Role::find($id);
        if ($role) {
            $role->delete();
        }
    }

    public function render()
    {

        if (strlen($this->search) == 0) {
            $roles = [];
        } else {
            $roles = \App\Models\Role::where('nom', 'LIKE', '%' . $this->search . '%')->get();
        }

        return view('livewire.role-search', ['roles' => $roles]);
    }
}
