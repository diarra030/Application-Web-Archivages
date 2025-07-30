<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Document;
use App\Models\folder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalVerrou extends Component
{
    public string $unlockCode = '';
    public bool $accessGranted = false;
    public $modelEncours;
    public $modelencourName;
    public $context = 'default';

    protected $listeners = ['setUnlockTarget'];

    public function setUnlockTarget($id, $model, $context = 'default')
    {
        $this->context = $context;
        $this->loadModel($id, $model);

        if ($this->accessGranted) {
            $this->dispatch('open-unlock-modal-js');
        }
    }

    public function mount($id = null, $model = null)
    {
        // Le mount initial ne fait rien, on attend l'événement
    }

    public function loadModel($id, $model)
    {
        $this->reset(['unlockCode', 'accessGranted', 'modelEncours', 'modelencourName']);

        if ($model == "folder") {
            $folder = folder::find($id);
            if ($folder && $folder->verrouille) {
                $this->modelEncours = $folder;
                $this->modelencourName = $folder->name;
                $this->accessGranted = true;
            }
        } elseif ($model == "document") {
            $document = Document::find($id);
            if ($document && $document->verrouille) {
                $this->modelEncours = $document;
                $this->modelencourName = $document->nom;
                $this->accessGranted = true;
            }
        }
    }


    public function verifyCode()
    {
        if ($this->modelEncours && Hash::check($this->unlockCode, $this->modelEncours->code_verrou)) {
            $this->accessGranted = false;

            ActivityLog::create([
                'action' => '✔️ Dévérouillage réussi',
                'description' => $this->modelencourName,
                'icon' => '✔️',
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);

            if ($this->context === 'move') {
                $this->dispatch('unlockSuccess');
            } else {
                $this->dispatch('checkAccess');
            }

            $this->dispatch('close-unlock-modal-js');
            $this->reset('unlockCode');

        } else {
            $this->addError('unlockCode', 'Code incorrect.');
            ActivityLog::create([
                'action' => '❌ Echec dévérouillage',
                'description' => $this->modelencourName,
                'icon' => '❌',
                'user_id' => Auth::id(),
                'confidentiel' => false,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.modal-verrou');
    }
}
