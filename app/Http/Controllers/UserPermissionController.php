<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use App\Models\User;
use App\Models\Folder;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données communes
        $request->validate([
            'user' => 'required|string|max:255',
            'permission' => 'required|in:L,E,LE',
            'folder_id' => 'nullable|integer|exists:folders,id',
            'document_id' => 'nullable|integer|exists:documents,id',
        ]);

        // Recherche de l'utilisateur par nom
        $user = User::where('name', $request->user)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'Utilisateur non trouvé.']);
        }

        $folder = null;
        $document = null;

        if ($request->filled('folder_id')) {
            $folder = Folder::find($request->folder_id);
            if (!$folder) {
                return redirect()->back()->withErrors(['folder_id' => 'Dossier non trouvé.']);
            }
        } elseif ($request->filled('document_id')) {
            $document = \App\Models\Document::find($request->document_id);
            if (!$document) {
                return redirect()->back()->withErrors(['document_id' => 'Document non trouvé.']);
            }

            $folder = $document->folder;
            if (!$folder) {
                return redirect()->back()->withErrors(['error' => 'Le document n\'a pas de dossier associé.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Ni dossier ni document spécifié.']);
        }

        // Liste de toutes les entités (dossiers + documents) concernées
        $entities = [];

        if ($document) {
            // Si un document spécifique est sélectionné, on ne traite que ce document
            $entities = [$document];
        } elseif ($folder) {
            // Si un dossier est sélectionné, on traite le dossier et tous ses enfants/documents
            $entities = $this->getAllFoldersAndDocuments($folder);
        }

        $processedCount = 0;

        // Créer ou mettre à jour les permissions pour chaque entité
        foreach ($entities as $entity) {
            $data = [
                'user' => $user->name,
                'user_id' => $user->id,
                'permission' => $request->permission,
            ];

            if ($entity instanceof Folder) {
                // Permission sur un dossier
                $data = array_merge($data, [
                    'folder' => $entity->name,
                    'folder_id' => $entity->id,
                    'document' => null,
                    'document_id' => null,
                ]);

                $existingPermission = UserPermission::where('user_id', $user->id)
                    ->where('folder_id', $entity->id)
                    ->whereNull('document_id')
                    ->first();

            } elseif ($entity instanceof \App\Models\Document) {
                // Permission sur un document
                $data = array_merge($data, [
                    'document' => $entity->nom,
                    'document_id' => $entity->id,
                    'folder' => null,
                    'folder_id' => null,
                ]);

                $existingPermission = UserPermission::where('user_id', $user->id)
                    ->where('document_id', $entity->id)
                    ->whereNull('folder_id')
                    ->first();
            }

            if ($existingPermission) {
                // Mise à jour si existe
                $existingPermission->update($data);
            } else {
                // Création si n'existe pas
                UserPermission::create($data);
            }

            $processedCount++;
        }

        // Message final
        if ($document) {
            $message = "Permission mise à jour pour {$user->name} sur le document \"{$document->nom}\".";
        } else {
            $message = "Permission mise à jour pour {$user->name} sur {$processedCount} élément(s) du dossier \"{$folder->name}\".";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Récupère TOUS les dossiers et documents à partir d'un dossier racine
     */
    private function getAllFoldersAndDocuments($folder)
    {
        $result = [$folder]; // Ajouter le dossier courant

        // Ajouter tous les documents du dossier
        foreach ($folder->files as $file) {
            $result[] = $file;
        }

        // Pour chaque sous-dossier, appeler la fonction récursivement
        foreach ($folder->children as $child) {
            $result = array_merge($result, $this->getAllFoldersAndDocuments($child));
        }

        return $result;
    }

    /**
     * Récupère toutes les permissions d'un utilisateur avec les détails
     */
    public function getUserPermissions($userId)
    {
        return UserPermission::where('user_id', $userId)
            ->with(['folder', 'document'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'user' => $permission->user,
                    'user_id' => $permission->user_id,
                    'type' => $permission->folder_id ? 'dossier' : 'document',
                    'folder_name' => $permission->folder,
                    'folder_id' => $permission->folder_id,
                    'document_name' => $permission->document,
                    'document_id' => $permission->document_id,
                    'permission' => $permission->permission,
                    'created_at' => $permission->created_at,
                    'updated_at' => $permission->updated_at,
                ];
            });
    }

    /**
     * Supprime toutes les permissions d'un utilisateur sur un dossier et ses enfants
     */
    public function removePermissions($userId, $folderId = null, $documentId = null)
    {
        if ($folderId) {
            $folder = Folder::find($folderId);
            if ($folder) {
                $entities = $this->getAllFoldersAndDocuments($folder);
                
                foreach ($entities as $entity) {
                    if ($entity instanceof Folder) {
                        UserPermission::where('user_id', $userId)
                            ->where('folder_id', $entity->id)
                            ->whereNull('document_id')
                            ->delete();
                    } elseif ($entity instanceof \App\Models\Document) {
                        UserPermission::where('user_id', $userId)
                            ->where('document_id', $entity->id)
                            ->whereNull('folder_id')
                            ->delete();
                    }
                }
            }
        } elseif ($documentId) {
            UserPermission::where('user_id', $userId)
                ->where('document_id', $documentId)
                ->delete();
        }
    }

    /**
     * Vérifie si un utilisateur a une permission spécifique
     */
    public function hasPermission($userId, $permission, $folderId = null, $documentId = null)
    {
        $query = UserPermission::where('user_id', $userId);

        if ($folderId) {
            $query->where('folder_id', $folderId)->whereNull('document_id');
        } elseif ($documentId) {
            $query->where('document_id', $documentId)->whereNull('folder_id');
        }

        $userPermission = $query->first();

        if (!$userPermission) {
            return false;
        }

        // Vérifier si la permission accordée inclut la permission demandée
        $permissions = [
            'L' => ['L'],
            'E' => ['E'],
            'LE' => ['L', 'E']
        ];

        return in_array($permission, $permissions[$userPermission->permission] ?? []);
    }

    /**
     * Nettoie les permissions en double (utilitaire de maintenance)
     */
    public function cleanupDuplicatePermissions()
    {
        // Supprimer les doublons pour les dossiers
        $folderDuplicates = UserPermission::selectRaw('user_id, folder_id, MAX(id) as max_id')
            ->whereNotNull('folder_id')
            ->whereNull('document_id')
            ->groupBy('user_id', 'folder_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($folderDuplicates as $duplicate) {
            UserPermission::where('user_id', $duplicate->user_id)
                ->where('folder_id', $duplicate->folder_id)
                ->whereNull('document_id')
                ->where('id', '!=', $duplicate->max_id)
                ->delete();
        }

        // Supprimer les doublons pour les documents
        $documentDuplicates = UserPermission::selectRaw('user_id, document_id, MAX(id) as max_id')
            ->whereNotNull('document_id')
            ->whereNull('folder_id')
            ->groupBy('user_id', 'document_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($documentDuplicates as $duplicate) {
            UserPermission::where('user_id', $duplicate->user_id)
                ->where('document_id', $duplicate->document_id)
                ->whereNull('folder_id')
                ->where('id', '!=', $duplicate->max_id)
                ->delete();
        }
    }
}