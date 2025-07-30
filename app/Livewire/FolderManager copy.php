<?php

namespace App\Livewire;

use App\Jobs\traitementQueueUploadFile;
use App\Models\ActivityLog;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Folder;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Url;

class FolderManager extends Component
{
    use WithFileUploads;
    public $currentFolder = [];
    public $folderName = '';
    public ?Folder $FolderEncours = null;
    public $mot_cle;
    public array $files = []; // important ! // Permet de stocker plusieurs fichiers
    #[Url(as: 'folderId')]
    public $parentId = null;
    public $successFolder;
    public $services;
    public $SessionService;
    public $deletingIndex = null;
    public $compteFileSelected = 0;
    public $confidence = false;
    public $users_confidence = [];
    public $folderId;
    public $folderCreateId;
    protected $listeners = ['deleteSelectedItems'];

    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]); // Supprime le fichier du tableau
            $this->files = array_values($this->files); // Réindexe le tableau pour éviter des trous
            $this->compteFileSelected = -1;
        }
        $this->dispatch('files-cleared');
    }
    public function removeAll()
    {
        $this->files = [];
        $this->compteFileSelected = 0;
        $this->mot_cle = '';
        $this->dispatch('files-cleared-all');
    }
    public function infoIdFocus()
    {
        $this->clickfolderId = $this->parentId;
    }

    public function mount($services = null, $folderId = null)
    {
        $this->folderCreateId = $this->parentId = $folderId;
        $this->services = $services;

        // Récupérer le chemin depuis la session
        $this->currentFolder = session()->get('currentFolder', []);

        $folder = Folder::find($folderId);

        //trouver le nom
        $folderName = $folder?->name ?? '';
        $this->SessionService = session()->get('SessionService');
        // Si ce chemin n'existe pas encore dans la session, on l'ajoute
        if (!collect($this->currentFolder)->pluck('id')->contains($folderId)) {
            $this->currentFolder[] = [
                'id' => $folderId,
                'name' => $folderName,
            ];
            session()->put('currentFolder', $this->currentFolder);
        }
    }

    public function navigateToFolder($folderId)
    {
        $this->parentId = $folderId;
        // Tronquer le tableau à partir du dossier cliqué
        $this->currentFolder = collect($this->currentFolder)
            ->takeUntil(fn($item) => $item['id'] === $folderId)
            ->push([
                'id' => $folderId,
                'name' => Folder::find($folderId)?->name ?? '',
            ])
            ->values()
            ->all();

        session()->put('currentFolder', $this->currentFolder);
        $this->dispatch('resetJS');
        $this->dispatch('changeUrl', ['detail' => $folderId]); //ecoute pour changer url dinamiquement sans rafraichir la page
        //return redirect()->route('folders.show', ['id' => $folderId]); // 👈 met à jour l'URL
    }

    public function resetFolderPath()
    {
        $this->currentFolder = [];
        session()->forget('currentFolder');
        return redirect()->to('/documentsFolder/' . $this->SessionService);
    }

    public function createFolder()
    {
        $this->validate(['folderName' => 'required']);
        // Vérifie si un dossier identique existe déjà
        $exists = Folder::where('name', $this->folderName)->where('parent_id', $this->folderCreateId)->where('service_id', $this->services?->id)->exists();

        if ($exists) {
            $this->dispatch('folderCreerexist');
        } else {
            Folder::create([
                'name' => $this->folderName,
                'parent_id' => $this->folderCreateId,
                'service_id' => $this->services?->id, // null si $this->services est null ou pas un objet
                'user_id' => Auth::id(),
            ]);
            ActivityLog::create([
                'action' => '✅ Dossier créé',
                'description' => $this->folderName,
                'icon' => '',
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);
            $this->folderName = '';
            $this->dispatch('folderCreer');
        }
        $this->dispatch('resetJS');
    }

    public $clickfolderId;
    public function getFolderId($id)
    {
        $this->clickfolderId = $id;
        $folder = Folder::find($id);
        $this->folderName = $folder->name;
        $this->dispatch('resetJS');
    }
    public $fileName;
    public $clickfileId;

    public function getFileId($id)
    {
        $this->clickfileId = $id;
        $file = Document::find($id);
        $this->fileName = $file->nom;
        $this->dispatch('resetJS');
    }
    //renommer un fichier ou dossier se trouve dans la vue blade createFolder.blade
    public function renameFile()
    {
        $this->validate(['fileName' => 'required|min:1']);
        // Vérifie si un dossier identique existe déjà
        $exists = Document::where('nom', $this->fileName)->where('folder_id', $this->parentId)->exists();
        if ($exists) {
            $this->dispatch('fileexist');
        } else {
            Document::where('id', $this->clickfileId)->update([
                'nom' => $this->fileName,
            ]);
            ActivityLog::create([
                'action' => '✅ Ficher modifié',
                'description' => $this->fileName,
                'icon' => '✔',
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);
            $this->fileName = '';
            $this->dispatch('fileEdit');
            $this->dispatch('resetJS');
        }
    }
    //renomer un Dossier se trouve dans la vue blade createFolder.blade
    public function renamer()
    {
        $this->validate(['folderName' => 'required']);
        // Vérifie si un dossier identique existe déjà
        $exists = Folder::where('name', $this->folderName)->where('parent_id', $this->folderCreateId)->where('service_id', $this->services?->id)->exists();
        if ($exists) {
            $this->dispatch('folderCreerexist');
        } else {
            Folder::where('id', $this->clickfolderId)->update([
                'name' => $this->folderName,
            ]);
            ActivityLog::create([
                'action' => '✅ Dossier modifié',
                'description' => $this->folderName,
                'icon' => '✔',
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);
            $this->folderName = '';
            $this->dispatch('folderEdit');
        }
        $this->dispatch('resetJS');
    }
    public function closeCreateModal()
    {
        $this->folderName = '';
        $this->dispatch('resetJS');
    }
    public $lock = false;
    public $code_verrouille;
    public function checkLock()
    {
        $this->lock = $this->lock;
    }
    public function deverrouOrVerrou($infoverrou)
    {
        if (isset($infoverrou['folder_id'])) {
            //on verrifie si c'est un objet d'un  Document ou dossier
            //fichier
            $verrou = Document::where('id', $infoverrou['id'])->first();

            if ($verrou['verrouille']) {
                // si le code verrouillage existe on enleve
                if (Hash::check($this->code_verrouille, $verrou->code_verrou)) {
                    $verrou->update([
                        'verrouille' => false,
                        'code_verrou' => '',
                    ]);
                    $this->getIds($verrou->id, 'file');
                    // Journalisation pour dévérouillage
                    ActivityLog::create([
                        'action' => ' Fichiers dévérrouiller',
                        'description' => $verrou->nom,
                        'icon' => ':)',
                        'user_id' => Auth::id(),
                        'confidentiel' => $this->confidence,
                    ]);
                    $this->dispatch('successVerrou');
                    $this->code_verrouille = '';
                } else {
                    $this->dispatch('errorVerrou');
                    $this->code_verrouille = '';
                }
            } else {
                //sinon on ajoute
                $verrou->update([
                    'verrouille' => true,
                    'code_verrou' => Hash::make($this->code_verrouille), // 🔐 Code à 4 chiffres
                ]);
                $this->getIds($verrou->id, 'file');
                //journalisation pour vérouillage
                ActivityLog::create([
                    'action' => '✅ Fichiers vérrouiller',
                    'description' => $verrou->nom,
                    'icon' => ':)',
                    'user_id' => Auth::id(),
                    'confidentiel' => $this->confidence,
                ]);
                $this->code_verrouille = '';
                $this->dispatch('successVerrou');
            }
        } else {
            // dossier A travailler ici pour verrouillage et deverrouillage

            $verrou = Folder::where('id', $infoverrou['id'])->first();
            if ($verrou['verrouille']) {
                // si le code verrouillage existe on enleve
                if (Hash::check($this->code_verrouille, $verrou->code_verrou)) {
                    $verrou->update([
                        'verrouille' => false,
                        'code_verrou' => '',
                    ]);
                    $this->getIds($verrou->id, 'folder');
                    // Journalisation pour dévérouillage
                    ActivityLog::create([
                        'action' => ' Dossier dévérrouiller',
                        'description' => $verrou->name,
                        'icon' => ':)',
                        'user_id' => Auth::id(),
                        'confidentiel' => $this->confidence,
                    ]);
                    $this->dispatch('successVerrou');
                    $this->code_verrouille = '';
                } else {
                    $this->dispatch('errorVerrou');
                    $this->code_verrouille = '';
                }
            } else {
                //sinon on ajoute
                $verrou->update([
                    'verrouille' => true,
                    'code_verrou' => Hash::make($this->code_verrouille), // 🔐 Code à 4 chiffres
                ]);
                $this->getIds($verrou->id, 'folder');
                //journalisation pour vérouillage
                ActivityLog::create([
                    'action' => '✅ Dossier vérrouiller',
                    'description' => $verrou->name,
                    'icon' => ':)',
                    'user_id' => Auth::id(),
                    'confidentiel' => $this->confidence,
                ]);
                $this->code_verrouille = '';
                $this->dispatch('successVerrou');
            }
        }
    }
    public function save()
    {
        $this->validate([
            'files.*' => 'required|file|mimes:txt,pdf,doc,docx,xls,xlsx,csv,ppt,pptx,png,jpeg|max:1000200',
        ]);
        if ($this->lock) {
            $this->validate(['code_verrouille' => 'required|min:4']);
        }
        foreach ($this->files as $file) {
            // Gestion du nom de fichier
            $originalName = pathinfo($file->getClientOriginalName())['filename'];
            $newName = $this->generateUniqueFilename($originalName);

            $nomFichier = pathinfo($newName)['filename']; // le nom du fichier sans l'extension
            // Stockage du fichier
            $path = $file->store('archives', 'public');
            // Création du document
            $document = Document::create([
                'nom' => $nomFichier,
                'filename' => $path,
                'type' => $file->getClientOriginalExtension(),
                'taille' => round($file->getSize() / 1024),
                'content' => '', // Contenu vide initialement
                'user_id' => Auth::id(),
                'verrouille' => $this->lock,
                'code_verrou' => Hash::make($this->code_verrouille), // 🔐 Code à 4 chiffres
                'folder_id' => $this->folderCreateId,
                'confidentiel' => $this->confidence,
            ]);

            // Attachement des relations
            $document->services()->attach($this->SessionService); //le document charger est lier au service

            if ($this->confidence) {
                $this->handleConfidentiality($document);
            }
            $fullPath = storage_path('app/public/' . $path);
            //$output = shell_exec("pdftotext -f 1 -l 5 $fullPath - 2>&1");
            //dd($output);
            // Dispatch du job
            traitementQueueUploadFile::dispatch($document, $this->mot_cle ?? '', $this->confidence); // Garantit une string vide si null

            // Journalisation
            ActivityLog::create([
                'action' => ' Début du traitement du document',
                'description' => $document->nom,
                'icon' => '...',
                'user_id' => Auth::id(),
                'confidentiel' => $this->confidence,
            ]);
        }
        if (count($this->files) > 0) {
            $this->dispatch('file_create');
        }

        $this->files = [];
        $this->compteFileSelected = 0;
        $this->mot_cle = '';
        $this->lock = false;
        $this->code_verrouille = '';

        $this->dispatch('resetJS');
    }
    //================================================================================

    //================================================================================
    private function generateUniqueFilename(string $originalName): string
    {
        $counter = 1;
        $baseName = $originalName; // On garde ce nom intact
        $newName = $baseName;

        while (Document::where('nom', $newName)->where('folder_id', $this->parentId)->exists()) {
            $newName = $baseName . '(' . $counter++ . ')';
        }

        return $newName;
    }

    private function handleConfidentiality(Document $document)
    {
        $document->confidentialite()->attach(Auth::user());

        if (!empty($this->users_confidence)) {
            $users = User::findMany($this->users_confidence);
            $document->confidentialite()->attach($users);
        }
    }
    public $idClickPropriete;
    public $docClickPropriete;
    public $infoPropriete;

    public function getIds($id, $doc)
    {
        if ($doc === 'folder') {
            $this->folderCreateId = $this->idClickPropriete = $id;
            $this->docClickPropriete = $doc;
            $this->infoPropriete = Folder::where('id', $id)->with('user')->first();
        }
        if ($doc === 'file') {
            $this->folderCreateId = $this->idClickPropriete = $id;
            $this->docClickPropriete = $doc;
            $this->infoPropriete = Document::where('id', $id)->with('user')->first();
        }
    }
    public function eraseInfoPropriete()
    {
        $this->infoPropriete = null;
        $this->docClickPropriete = null;
        $this->folderCreateId = $this->parentId;
    }
    public function deleteFolder($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();
        $this->dispatch('folderDeleted');
        // Journalisation
        ActivityLog::create([
            'action' => '❌ Dossier supprimé',
            'description' => $folder->name,
            'icon' => '✔',
            'user_id' => Auth::id(),
            'confidentiel' => false,
        ]);
        $this->dispatch('resetJS');
        $this->infoPropriete = null;
    }
    public function deleteFile($id)
    {
        $file = Document::findOrFail($id);
        $file->delete();
        $this->dispatch('fileDeleted');
        // Journalisation
        ActivityLog::create([
            'action' => '❌ Fichier supprimé',
            'description' => $file->nom,
            'icon' => '✔',
            'user_id' => Auth::id(),
            'confidentiel' => false,
        ]);
        $this->dispatch('resetJS');
        $this->infoPropriete = null;
    }
    // les fonction de suppression Multiple de folders ou et files

    public function deleteSelectedItems(array $items)
    {
        \Log::info('deleteSelectedItems appelé', compact('items'));

        $deletedFolders = 0;
        $deletedFiles = 0;
        $skippedFolders = 0;
        $skippedFiles = 0;
        $lockedItems = [];

        foreach ($items as $item) {
            if (!isset($item['id'], $item['type'])) {
                continue;
            }

            $id = intval($item['id']);
            $type = $item['type'];

            if ($type === 'folder') {
                $folder = Folder::with(['files', 'children.files', 'children.children'])->find($id);

                if ($folder) {
                    $lockedInFolder = $this->getLockedItemsInFolder($folder);
                    if ($folder->verrouille) {
                        $skippedFolders++;
                        $lockedItems[] = '📁 ' . $folder->name;
                        continue;
                    }

                    if (!empty($lockedInFolder)) {
                        $skippedFolders++;
                        $lockedItems = array_merge($lockedItems, $lockedInFolder);
                        continue;
                    }

                    $this->deleteFolderRecursively($folder);
                    $deletedFolders++;
                }
            }

            if ($type === 'file') {
                $file = Document::find($id);
                if ($file) {
                    if ($file->verrouille) {
                        $skippedFiles++;
                        $lockedItems[] = '📄 ' . $file->nom;
                        continue;
                    }

                    $this->deleteFileDirect($file);
                    $deletedFiles++;
                }
            }
        }

        $message = "✅ $deletedFolders dossier(s) et $deletedFiles fichier(s) supprimé(s).";

        if (!empty($lockedItems)) {
            $message .= '<br>⚠️ Car Certains éléments sont verrouillés :<br>' . implode('<br>', $lockedItems);
        }

        session()->flash('message', $message);
        $this->dispatch('foldersUpdated');
        $this->dispatch('filesUpdated');
        $this->dispatch('resetJS');
    }
    protected function getLockedItemsInFolder(Folder $folder): array
    {
        $locked = [];

        // Vérifie les fichiers du dossier
        foreach ($folder->files as $file) {
            if ($file->verrouille) {
                $locked[] = '📄 ' . $file->nom;
            }
        }

        // Vérifie les sous-dossiers
        foreach ($folder->children as $child) {
            if ($child->verrouille) {
                $locked[] = '📁 ' . $child->name;
            }

            // Vérifie récursivement les sous-dossiers
            $locked = array_merge($locked, $this->getLockedItemsInFolder($child));
        }

        return $locked;
    }

    private function containsLockedItems(Folder $folder): bool
    {
        // Si le dossier est verrouillé lui-même
        if ($folder->verrouille) {
            return true;
        }

        // Vérifie les fichiers du dossier
        foreach ($folder->files as $file) {
            if ($file->verrouille) {
                return true;
            }
        }

        // Vérifie les sous-dossiers récursivement
        foreach ($folder->children as $subfolder) {
            $subfolder->loadMissing(['files', 'children']);
            if ($this->containsLockedItems($subfolder)) {
                return true;
            }
        }

        return false;
    }

    protected function deleteFolderRecursively(folder $folder)
    {
        // Supprimer tous les fichiers dans le dossier
        foreach ($folder->files as $file) {
            $this->deleteFileDirect($file);
        }

        // Supprimer récursivement les sous-dossiers
        foreach ($folder->children as $childFolder) {
            $this->deleteFolderRecursively($childFolder);
        }

        // Supprimer le dossier lui-même
        $folder->delete();
        // Journaliser l’action
        ActivityLog::create([
            'action' => '❌ Fichier supprimé',
            'description' => $folder->name,
            'icon' => '✔',
            'user_id' => Auth::id(),
            'confidentiel' => false,
        ]);
    }

    protected function deleteFileDirect(Document $file)
    {
        $path = public_path($file->filename);

        // Supprimer physiquement le fichier s’il existe
        if ($file->filename && file_exists($path)) {
            @unlink($path);
        }

        // Supprimer le fichier en base de données
        $file->delete();

        // Journaliser l’action
        ActivityLog::create([
            'action' => '❌ Fichier supprimé',
            'description' => $file->nom,
            'icon' => '✔',
            'user_id' => Auth::id(),
            'confidentiel' => false,
        ]);
    }
    //fin les fonction de suppression Multiple de folders ou et files

    // public function render()
    // {
    //     if (isset($this->services)) {
    //         $folders = Folder::where('service_id', $this->services->id)->where('parent_id', NULL)->withCount('children')->withCount('files')->get();
    //     } else {
    //         $folders = Folder::where('parent_id', $this->parentId)->withCount('children')->withCount('files')->get(); // ajoute le nombre de documents;
    //     }
    //     if (isset($this->SessionService)) {
    //         $SessionServiceinfo = Service::find($this->SessionService);
    //     } else {
    //         $SessionServiceinfo = "";
    //     }
    //     $infoProprietes =

    //         $fichiers = Document::where('folder_id', $this->parentId)->get();

    //     return view('livewire.folder-manager', compact('folders', 'fichiers', 'SessionServiceinfo', 'infoProprietes'));
    // }
    public function render()
    {
        $user = auth()->user(); // Utilisateur connecté

        if (isset($this->services)) {
            // Cas avec service spécifique
            $foldersQuery = Folder::where('service_id', $this->services->id)->whereNull('parent_id');
        } else {
            // Cas avec parentId
            $foldersQuery = Folder::where('parent_id', $this->parentId);
        }

        // Filtrer selon les permissions sur les dossiers
        $authorizedFolderIds = $user->permissions()->whereNotNull('folder_id')->pluck('folder_id')->toArray();

        $folders = $foldersQuery->whereIn('id', $authorizedFolderIds)->withCount('children')->withCount('files')->get();

        // Obtenir les documents dans ce dossier s'ils sont autorisés
        $documentQuery = Document::where('folder_id', $this->parentId);

        $authorizedDocumentIds = $user->permissions()->whereNotNull('document_id')->pluck('document_id')->toArray();

        $fichiers = $documentQuery->whereIn('id', $authorizedDocumentIds)->get();

        // Récupération du service en session
        if (isset($this->SessionService)) {
            $SessionServiceinfo = Service::find($this->SessionService);
        } else {
            $SessionServiceinfo = '';
        }

        $infoProprietes = ''; // à compléter si tu as d'autres infos à afficher

        return view('livewire.folder-manager', compact('folders', 'fichiers', 'SessionServiceinfo', 'infoProprietes'));
    }
}
