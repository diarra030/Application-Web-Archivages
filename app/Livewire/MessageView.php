<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Document;

class MessageView extends Component
{
    use WithPagination;

    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $taggedDocuments = $user
            ->document()
            ->withPivot('id', 'tagger', 'message', 'new')
            ->orderBy('pivot_created_at', 'desc')
            ->paginate(5);

        $taggerDocuments = Document::whereHas('users', function ($query) {
                $query->where('tagger', Auth::user()->id);
            })
            ->with(['users' => function ($query) {
                $query->orderBy('pivot_created_at', 'desc'); // Tri des relations pivot
            }])
            ->paginate(5);

        return view('livewire.message-view', ['user' => $user, 'taggedDocuments' => $taggedDocuments, 'taggerDocuments' => $taggerDocuments]);
    }
}
