<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FastSearch extends Component
{
    public $query = '';
    public $service;
    public $fileType = '';
    public $uploadDate = '';
    public $showAdvancedSearch = false;
    public $searchType = 'all'; // Valeur par défaut : chercher partout
    public $searchInCurrentFolderOnly = false;
    public $currentFolderId = null;


    public $service_ident;

    public function mount($currentFolderId = null)
    {
        $this->currentFolderId = $currentFolderId;
        
    }


    public function render()
    {
        $user = Auth::user();
        $documents = collect();
        $folders = collect();
        $formattedDocuments = [];

        if (strlen($this->query) >= 2) {
            // Recherche de documents (si 'tous' ou 'documents' est sélectionné)
            if ($this->searchType === 'all' || $this->searchType === 'documents') {
                $docSearch = Document::search($this->query, function ($meilisearch, $query, $options) {
                    $filters = [];

                    if ($this->searchInCurrentFolderOnly && $this->currentFolderId) {
                        $filters[] = 'folder_id = ' . $this->currentFolderId;
                    }

                    if (!empty($this->fileType)) {
                        $filters[] = 'type = "' . $this->fileType . '"';
                    }
                    if (!empty($this->uploadDate)) {
                        $date = \Carbon\Carbon::parse($this->uploadDate)->startOfDay()->timestamp;
                        $filters[] = 'created_at >= ' . $date;
                    }
                    $options['matchingStrategy'] = 'all';
                    if (!empty($filters)) {
                        $options['filter'] = implode( "AND" , $filters);
                    }

                    // Ajout du surlignage
                    $options['attributesToHighlight'] = ['nom', 'content'];
                    $options['highlightPreTag'] = '<em class="font-bold text-blue-600">';
                    $options['highlightPostTag'] = '</em>';

                    return $meilisearch->search($query, $options);
                });

                $results = $docSearch->raw();
                $hits = collect($results['hits']);
                $documentIds = $hits->pluck('id')->all();

                if (count($documentIds) > 0) {
                    // On force l'ordre de la BDD à être le même que celui de Meilisearch
                    $documents = Document::whereIn('id', $documentIds)
                                     ->orderByRaw('FIELD(id, ' . implode(',', $documentIds) . ')')
                                     ->get();
                } else {
                    $documents = collect();
                }
                
                // Formater les documents pour la vue
                foreach ($hits as $hit) {
                    $formattedDocuments[$hit['id']] = $hit['_formatted'];
                }

            }

            // Recherche de dossiers (si 'tous' ou 'dossiers' est sélectionné)
            if ($this->searchType === 'all' || $this->searchType === 'folders') {
                $folderSearch = Folder::search($this->query);

                if ($this->searchInCurrentFolderOnly && $this->currentFolderId) {
                    $folderSearch->where('parent_id', $this->currentFolderId);
                }


                if ($user->role->nom === "SuperAdministrateur" || $user->role->nom === "Administrateur") {
                    $folders = $folderSearch->get();
                } else {
                    $folders = $folderSearch->where('service_id', $user->service_id)->get();
                }
            }
        }

        return view('livewire.fast-search', [
            'documents' => $documents,
            'folders' => $folders,
            'formattedDocuments' => $formattedDocuments,
        ]);
    }
}

