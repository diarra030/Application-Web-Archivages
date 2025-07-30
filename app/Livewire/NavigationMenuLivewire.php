<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavigationMenuLivewire extends Component
{



    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);

        // Recalculer les nouveaux messages non lus
        $nombreNewMessage = $user
            ->document()
            ->withPivot('new')
            ->wherePivot('new', true)
            ->count();

        return view('livewire.navigation-menu-livewire', ['nombreNewMessage' => $nombreNewMessage]);
    }
}
