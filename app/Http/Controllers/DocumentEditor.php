<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Strings;

class DocumentEditor extends Controller
{
    public $document;
    public $url ;
    // Générer un token JWT pour sécuriser l'accès
    private function generateToken($payload)
    {
        $secret = env('ONLYOFFICE_SECRET', 'default_secret_key'); // ✅ Utiliser une clé dynamique
        return JWT::encode($payload, $secret, 'HS256');
    }

    public function index($id)
    {
        $user = Auth::user();
        $this->document = Document::findOrFail($id);
        $filename = $this->document->filename;
        $documentServerUrl = env('ONLYOFFICE_URL', 'http://127.0.0.1:8081'); // ✅ Vérifie le bon port Docker
        $documentUrl = asset("storage/{$filename}");
        $callbackUrl = url("api/wopi/files/{$id}"); // ✅ Correction de l'URL de callback
        
        $documentKey = md5($filename . time()); // ✅ Générer une clé unique

        // Configuration envoyée à ONLYOFFICE
        $config = [
            "document" => [
                "fileType" => pathinfo($filename, PATHINFO_EXTENSION),
                "key" => $documentKey,
                "title" => "{$user->name} travaille sur: {$this->document->nom}",
                "url" => $documentUrl,
            ],
            "editorConfig" => [
                "callbackUrl" => $callbackUrl, // ✅ Correction du callback
                "mode" => "edit",
                "autosave" => true,  // ✅ Permet l'enregistrement automatique
                "lang" => "fr",
                "user" => [
                    "id" => strval  ($user->id),
                    "name" => $user->name,
                ],
                
            ],
            "permissions" => [
                "edit" => true,
                "download" => true,
                "print" => true,
                "comment" => true,
                "fillForms" => true,
                "modifyContentControl" => true,
                "modifyFilter" => true,
                "review" => true,
            ],
            "width" => "100%",
            "height" => "100%",
            "type" => "desktop or mobile"
        ];

        // Générer un token JWT pour sécuriser le document
        $token = $this->generateToken($config);
        $config["token"] = $token;

        return view('documentEdit', compact('documentServerUrl', 'documentUrl', 'filename', 'token', 'config'));
    }

    public function callback(Request $request, $id)
   {
    $data = $request->all();
    $document = Document::findOrFail($id); // Récupérer le document
    $filename = $document->filename; // Accéder au nom du fichier
    \Log::info('Données reçues depuis ONLYOFFICE:', ['data' => json_encode($data, JSON_PRETTY_PRINT)]);
    
    if (!isset($data['status'])) {
        \Log::info('Document est Manquant:');
        return response()->json(['error' => 'Statut manquant'], 400);
    }

    switch ($data['status']) {
        case 1:
            // Le document est en édition
            \Log::info('Document en cours edition ='.$id);
            return response()->json(['message' => 'Document en cours d\'édition']);
        case 2:
            if (isset($data['status']) && $data['status'] == 2) {
                $fileUrl = $data['url'] ?? null;
                //$fileName = 'document_modifie.docx'; // Nom du fichier enregistré
        
                if ($fileUrl) {
                    // Télécharger le fichier
                    $fileContents = file_get_contents($fileUrl);
                    
                    if ($fileContents !== false) {
                        // Enregistrer dans storage/app/archives/
                        Storage::disk('public')->put("$filename", $fileContents);
                        \Log::info("✅ Fichier enregistré : storage/app/archives/$filename");
                        return response()->json(['status' => 'success']);
                    } else {
                        \Log::error("❌ Erreur lors du téléchargement du fichier.");
                        return response()->json(['status' => 'error', 'message' => 'Download failed']);
                    }
                }
            }
        
        case 4:
            // Fermeture de l'édition
            \Log::info('Document en edition Terminé');
             // Journalisation
    ActivityLog::create([
        'action' => 'Modification du document',
        'description' => $document->nom,
        'icon' => '...',
        'user_id' => Auth::id(),
        'confidentiel' => 0,
    ]);
            return response()->json(['message' => 'Édition terminée']);
        default:
            return response()->json(['message' => 'Statut non géré']);
        }


   
    return response()->json(['message' => 'OK']);
   }
}
