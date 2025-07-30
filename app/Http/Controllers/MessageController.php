<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function show($pivotId)
    {
        $user = Auth::user();
        $pivot = DB::table('document_user')->where('id', $pivotId)->first();
        $document = Document::findOrFail($pivot->document_id);
        $tagger = User::find($pivot->tagger);

        // Mettre à jour la valeur de la colonne `new`
        DB::table('document_user')->where('id', $pivotId)->update(['new' => false]);

        return view('message.show', compact('document', 'tagger', 'pivot'));
    }

    public function showSend($pivotId)
    {
        $user = Auth::user();
        $pivot = DB::table('document_user')->where('id', $pivotId)->first();
        $document = Document::findOrFail($pivot->document_id);
        $tagged = User::find($pivot->user_id);

        return view('message.showSend', compact('document', 'tagged', 'pivot'));
    }


    public function index()
    {
        return view('message');
    }
}
