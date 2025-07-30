<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageeControl extends Component
{
    public $nombreNewMessage = 0;

    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);

        // Recalculer les nouveaux messages non lus
        $this->nombreNewMessage = $user
            ->document()
            ->withPivot('new')
            ->wherePivot('new', true)
            ->count();

        return view('livewire.messagee-control', ['nombreNewMessage' => $this->nombreNewMessage]);
    }
}
