<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'document-id' => 'required|int|exists:documents,id',
            'user-input' => 'required|string',
            'user-message' => 'required|string',
        ]);

        $document = Document::find($validatedData['document-id']);
        $tagger = Auth::id();
        $message = $validatedData['user-message'];

        // Extraction des emails (séparés par espaces)
        $taggedEmails = preg_split('/\s+/', $validatedData['user-input']);
        $taggedEmails = array_filter(array_unique($taggedEmails));

        foreach ($taggedEmails as $email) {
            $tagged = User::where('email', trim($email))->first();
            if ($tagged) {
                $document->users()->attach(
                    $tagged->id,
                    ['tagger' => $tagger, 'message' => $message, 'new' => true]
                );
            }
        }

        return redirect()->route('document')->with('success', 'Message envoyé avec succès');
    }

    public function index($id)
    {
        $document = Document::findOrFail($id);

        if ($document->confidentiel) {
            $admin_users = User::whereIn('role_id', [0, 1])->get();
            $users_tag_serv = User::where('id', '!=', Auth::id())
                ->whereIn('service_id', $document->services->pluck('id'))
                ->whereHas('confidentialite', function ($query) use ($document) {
                    // Ta logique ici (vide pour l’instant)
                })->get();

            $users_tag = $users_tag_serv->merge($admin_users);
        } else {
            $admin_users = User::whereIn('role_id', [0, 1])->get();
            $users_tag_serv = User::where('id', '!=', Auth::id())
                ->whereIn('service_id', $document->services->pluck('id'))
                ->orWhereIn('role_id', [0, 1])
                ->get();

            $users_tag = $users_tag_serv->merge($admin_users);
        }

        return view('tag', compact('document', 'users_tag'));
    }
}
