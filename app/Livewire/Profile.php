<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profile extends Component
{



    public $modifier = false;

    public function open()
    {
        $this->modifier = true;
    }

    public function close()
    {
        $this->modifier = false;
    }

    public function render()
    {
        $sessions = DB::table('sessions')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('livewire.profile', ['sessions' => $sessions])->with('success', 'Informations modifiées avec succès.');
    }
}
