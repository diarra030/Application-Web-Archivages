<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServiceSearch extends Component
{
    public $query = '';
    public $services_ident;

    public function render()
    {
        $user = User::find(Auth::user()->id);

        if (strlen($this->query) == 0) {
            $services = [];
        } else {
            $services = Service::where('nom', 'like', '%' . $this->query . '%')
            ->paginate(10);
            $this->services_ident = $user->identificate()->pluck('nom')->toArray();
        }

        return view('livewire.service-search', ['services' => $services, 'services_ident' => $this->services_ident]);
    }
}
