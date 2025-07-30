<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageContent extends Component
{
    public $taggedDocuments;

    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->taggedDocuments = $user
            ->document()
            ->withPivot('id', 'tagger', 'message', 'new')
            ->wherePivot('new', true)
            ->orderBy('pivot_created_at', 'desc')
            ->take(2)
            ->get();

        return view('livewire.message-content', ['user' => $user,'taggedDocuments' => $this->taggedDocuments]);
    }
}
